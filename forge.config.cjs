module.exports = {
  packagerConfig: {
    ignore: [
      /(.eslintrc.json)|(.gitignore)|(electron.vite.config.ts)|(forge.config.cjs)|(tsconfig.*)/,
      /^\/node_modules\/.vite/,
      /^\/.git/,
      /^\/.github/,
      /^\/core/,
      /^\/libs/,
      /^\/miservidor/,
      /^\/servidor/,
      /^\/php/,
      /^\/sistema/
    ],
    asar: true,
    extraResource: [
      "./core/",
      "./libs/",
      "./miservidor/",
      "./php/",
      "./sistema/",
      "./LICENSE",
      "./README.md"
    ]
  },
  plugins: [
    {
      name: '@electron-forge/plugin-auto-unpack-natives',
      config: {}
    }
  ],
  makers: [
    {
      name: "@electron-forge/maker-zip",
      platforms: [
        "linux"
      ]
    }
  ],
  publishers: []
}
