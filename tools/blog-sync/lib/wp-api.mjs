// Minimal WP REST API client with optional Basic auth (Application Passwords).

function authHeader({ user, password }) {
  if (!user || !password) return {};
  const token = Buffer.from(`${user}:${password}`).toString('base64');
  return { Authorization: `Basic ${token}` };
}

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

  return {
    root,

    async getPosts({ perPage = 100, embed = true, status } = {}) {
      const query = { per_page: String(perPage), _embed: embed ? '1' : '0' };
      if (status) query.status = status;
      return request('/posts', { query });
    },

    async findPostBySlug(slug) {
      const query = { slug, status: 'any', context: 'edit', per_page: '1' };
      const results = await request('/posts', { query });
      return results[0] || null;
    },

    async createPost(payload) {
      return request('/posts', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
    },

    async updatePost(id, payload) {
      return request(`/posts/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
    },

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
