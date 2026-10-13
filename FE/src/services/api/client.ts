import type { ApiRequestOptions } from '@/types/api'
import { readRequiredEnv } from '@/utils/env'

export class ApiError extends Error {
  readonly status: number
  readonly payload: unknown

  constructor(status: number, payload: unknown) {
    super(`API request failed with status ${status}`)
    this.name = 'ApiError'
    this.status = status
    this.payload = payload
  }
}

export function buildApiUrl(baseUrl: string, path: string): URL {
  if (path.startsWith('//') || /^[a-z][a-z\d+\-.]*:/i.test(path)) {
    throw new Error('API path must be relative to the configured base URL.')
  }

  const normalizedBase = baseUrl.endsWith('/') ? baseUrl : `${baseUrl}/`
  const normalizedPath = path.replace(/^\/+/, '')

  return new URL(normalizedPath, normalizedBase)
}

function buildHeaders(headers: HeadersInit | undefined, hasBody: boolean): Headers {
  const result = new Headers(headers)

  if (!result.has('Accept')) {
    result.set('Accept', 'application/json')
  }

  if (hasBody && !result.has('Content-Type')) {
    result.set('Content-Type', 'application/json')
  }

  return result
}

async function readResponseBody(response: Response): Promise<unknown> {
  const text = await response.text()

  if (text.trim() === '') {
    return null
  }

  try {
    return JSON.parse(text) as unknown
  } catch {
    return text
  }
}

export async function apiRequest<TResponse>(
  path: string,
  options: ApiRequestOptions = {},
): Promise<TResponse> {
  const { body, headers, ...init } = options
  const baseUrl = readRequiredEnv('VITE_API_BASE_URL', import.meta.env.VITE_API_BASE_URL)
  const hasBody = body !== undefined

  const response = await fetch(buildApiUrl(baseUrl, path), {
    ...init,
    headers: buildHeaders(headers, hasBody),
    body: hasBody ? JSON.stringify(body) : undefined,
  })

  const payload = await readResponseBody(response)

  if (!response.ok) {
    throw new ApiError(response.status, payload)
  }

  return payload as TResponse
}
