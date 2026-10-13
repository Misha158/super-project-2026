import { describe, expect, it } from 'vitest'

import { buildApiUrl } from '@/services/api'

describe('buildApiUrl', () => {
  it('joins a relative path to the base URL', () => {
    expect(buildApiUrl('http://localhost:3000', '/health').href).toBe(
      'http://localhost:3000/health',
    )
  })

  it('keeps a base path when the base URL has no trailing slash', () => {
    expect(buildApiUrl('http://localhost:3000/api', 'users').href).toBe(
      'http://localhost:3000/api/users',
    )
  })

  it('rejects an absolute path', () => {
    expect(() => buildApiUrl('http://localhost:3000', 'https://example.com/health')).toThrow(
      /relative/,
    )
  })
})
