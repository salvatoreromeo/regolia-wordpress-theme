import TurndownService from 'turndown';

const service = new TurndownService({
  headingStyle: 'atx',
  codeBlockStyle: 'fenced',
  bulletListMarker: '-',
  emDelimiter: '_',
  strongDelimiter: '**',
});

// Preserve WordPress shortcodes and figure/img better
service.keep(['figure', 'iframe']);

export function htmlToMarkdown(html) {
  if (!html) return '';
  const decoded = html
    .replace(/&#8217;/g, '’')
    .replace(/&#8220;/g, '“')
    .replace(/&#8221;/g, '”')
    .replace(/&#8230;/g, '…')
    .replace(/&hellip;/g, '…')
    .replace(/&amp;/g, '&')
    .replace(/&nbsp;/g, ' ');
  return service.turndown(decoded).trim() + '\n';
}
