module.exports = {
  plugins: {
    '@tailwindcss/postcss': {},
    'postcss-url': {
      url: (asset) => {
        if (asset.url.includes('webfonts/')) {
          // Extract the font filename (e.g., fa-solid-900.woff2)
          const parts = asset.url.split('/');
          const filename = parts[parts.length - 1];
          return `../webfonts/${filename}`;
        }
        return asset.url;
      }
    }
  }
}
