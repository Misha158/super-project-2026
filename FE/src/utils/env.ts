export function readRequiredEnv(name: string, value: string | undefined): string {
  if (typeof value !== 'string' || value.trim() === '') {
    throw new Error(`${name} is not set. Copy .env.example to .env and set a value.`)
  }

  return value.trim()
}
