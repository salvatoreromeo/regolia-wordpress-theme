// Minimal WP REST API client with optional Basic auth (Application Passwords).
// Works against both posts and pages — the caller passes the endpoint type
// ("posts" or "pages") to every item method. Other endpoints (media, terms)
// are still typed.

function authHeader({ user, password }) {
  if (!user || !password) return {};
  const token = Buffer.from(`${user}:${password}`).toString('base64');
  return { Authorization: `Basic ${token}` };
}

export const SUPPORTED_TYPES = ['posts', 'pages'];

export function createClient({ baseUrl, user, password } = {}) {
  if (!baseUrl) throw new Error('baseUrl is required');
  const root = baseUrl.replace(/\/$/, '') + '/wp-json/wp/v2';
  const auth = authHeader({ user, password });

  async function request(path, { method = 'GET', headers = {}, body, query } = {}) {
    const qs = query
      ? '?' + new URLSearchParams(query).toString()
      : '';
    const url = `${root}${path}${qs}`;
    const res = await fetch(url, {
      method,
      headers: { ...auth, ...headers },
      body,
    });
    const text = await res.text();
    let data;
    try { data = text ? JSON.parse(text) : null; } catch { data = text; }
    if (!res.ok) {
      const msg = (data && data.message) || res.statusText;
      const err = new Error(`${method} ${path} → ${res.status} ${msg}`);
      err.status = res.status;
      err.data = data;
      throw err;
    }
    return data;
  }

  function assertType(type) {
    if (!SUPPORTED_TYPES.includes(type)) {
      throw new Error(`Unsupported type: ${type}. Expected one of: ${SUPPORTED_TYPES.join(', ')}`);
    }
  }

  return {
    root,

    /* ── Generic item API (posts + pages) ── */

    async getItems(type, { perPage = 100, embed = true, status } = {}) {
      assertType(type);
      const query = { per_page: String(perPage), _embed: embed ? '1' : '0' };
      if (status) query.status = status;
      return request(`/${type}`, { query });
    },

    async findItemBySlug(type, slug) {
      assertType(type);
      const query = { slug, status: 'any', context: 'edit', per_page: '1' };
      const results = await request(`/${type}`, { query });
      return results[0] || null;
    },

    async createItem(type, payload) {
      assertType(type);
      return request(`/${type}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
    },

    async updateItem(type, id, payload) {
      assertType(type);
      return request(`/${type}/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
    },

    /* ── Media ── */

    async uploadMedia({ filename, contentType, data, title, altText }) {
      const headers = {
        'Content-Type': contentType,
        'Content-Disposition': `attachment; filename="${filename}"`,
      };
      const media = await request('/media', { method: 'POST', headers, body: data });
      if (title || altText) {
        const patch = {};
        if (title) patch.title = title;
        if (altText) patch.alt_text = altText;
        return request(`/media/${media.id}`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(patch),
        });
      }
      return media;
    },

    /* ── Taxonomies (posts only) ── */

    async listCategories() {
      return request('/categories', { query: { per_page: '100' } });
    },

    async createCategory(name) {
      return request('/categories', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name }),
      });
    },

    async listTags() {
      return request('/tags', { query: { per_page: '100' } });
    },

    async createTag(name) {
      return request('/tags', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name }),
      });
    },
  };
}
