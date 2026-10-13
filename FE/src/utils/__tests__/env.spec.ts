import { describe, expect, it } from 'vitest'

import { readRequiredEnv } from '@/utils/env'

describe('readRequiredEnv', () => {
  it('returns a trimmed value', () => {
    expect(readRequiredEnv('VITE_API_BASE_URL', '  http://localhost:3000  ')).toBe(
      'http://localhost:3000',
    )
  })

  it('rejects a missing value', () => {
    expect(() => readRequiredEnv('VITE_API_BASE_URL', '   ')).toThrow(/VITE_API_BASE_URL/)
  })
})
