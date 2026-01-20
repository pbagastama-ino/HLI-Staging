import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useLocalization() {
  const page = usePage()
  
  // Get current locale from page props, default to 'en'
  const currentLocale = computed(() => {
    return page.props.locale || 'en'
  })
  
  // Function to generate localized URL
  const getLocalizedUrl = (path, locale = null) => {
    const targetLocale = locale || currentLocale.value
    // Remove leading slash and locale prefix if present
    const cleanPath = path.replace(/^\//, '').replace(/^(en|id)\//, '')
    // If path is just '/', return locale root
    if (cleanPath === '' || cleanPath === 'en' || cleanPath === 'id') {
      return `/${targetLocale}`
    }
    return `/${targetLocale}/${cleanPath}`
  }
  
  return {
    currentLocale,
    getLocalizedUrl
  }
}
