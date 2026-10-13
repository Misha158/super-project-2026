import { createPinia, setActivePinia } from 'pinia'
import { beforeEach, describe, expect, it } from 'vitest'

import { useCounterStore } from '@/stores/counter'

describe('useCounterStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('starts at zero', () => {
    const counter = useCounterStore()

    expect(counter.count).toBe(0)
    expect(counter.doubleCount).toBe(0)
  })

  it('increments and resets the shared count', () => {
    const counter = useCounterStore()

    counter.increment()
    counter.increment()

    expect(counter.count).toBe(2)
    expect(counter.doubleCount).toBe(4)

    counter.reset()

    expect(counter.count).toBe(0)
    expect(counter.doubleCount).toBe(0)
  })
})
