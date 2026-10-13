# Super Project

Vue 3 frontend starter for a full-stack learning project. The interface is small on purpose: routing, one Pinia store, and a Fetch-based API client ready for a backend.

## Setup

Node.js 22's bundled npm 10 can crash while installing this dependency tree (`edgesOut`). Use npm 11.6 or newer:

```sh
npm install -g npm@11
npm install
```

Copy `.env.example` to `.env` before calling the API:

```sh
Copy-Item .env.example .env
```

Start the dev server:

```sh
npm run dev
```

## Scripts

| Command | Purpose |
| --- | --- |
| `npm run dev` | Start the Vite dev server |
| `npm run build` | Type-check and create a production build |
| `npm run preview` | Preview the production build |
| `npm run type-check` | Type-check Vue and TypeScript |
| `npm run lint` | Run Oxlint and ESLint |
| `npm run format` | Format `src` with Prettier |
| `npm run test:unit` | Run Vitest |

`npm run test:unit` watches in an interactive terminal. Run it once with:

```sh
npm run test:unit -- --run
```

## Environment

`VITE_API_BASE_URL` is the backend origin. `.env` files are gitignored. `.env.example` is the committed placeholder.

## Editor

[VS Code](https://code.visualstudio.com/) with [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) gives TypeScript support inside `.vue` files. This project type-checks with `vue-tsc`.
