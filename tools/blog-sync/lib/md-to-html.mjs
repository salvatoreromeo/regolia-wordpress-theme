import { marked } from 'marked';

marked.setOptions({
  gfm: true,
  breaks: false,
});

export function markdownToHtml(md) {
  if (!md) return '';
  return marked.parse(md.trim());
}
