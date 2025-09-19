import { usePage } from '@inertiajs/vue3';
import arTranslations from '../translations/ar.json';
import enTranslations from '../translations/en.json';

// Define interface for the language dictionaries
interface LanguageDict {
    [key: string]: string | LanguageDict;
}

/**
 * Translate a string with support for dot notation and replacements
 * @param {string} key - a dot-separated path to the translation string
 * @param {Record<string, string | number | boolean>} replace - an object of key value pairs to replace in the string
 * @returns {string} - the translated string with replacements
 */
export function $trans(key: string, replace: Record<string, string | number | boolean> = {}): string {
    // Get the current locale from page props or use 'en' as default
    const locale = (usePage().props.locale as string) || 'en';

    // Select the appropriate translation file
    const translations: LanguageDict = locale === 'ar' ? arTranslations : enTranslations;

    // Handle dot notation to access nested translations
    let translation = key;

    if (key.includes('.')) {
        const parts = key.split('.');
        let current: any = translations;

        // Navigate through the nested objects
        for (const part of parts) {
            if (current && typeof current === 'object' && part in current) {
                current = current[part];
            } else {
                current = null;
                break;
            }
        }

        if (current && typeof current === 'string') {
            translation = current;
        }
    } else if (translations && typeof translations[key] === 'string') {
        translation = translations[key] as string;
    }

    // Replace placeholders in the translation
    Object.keys(replace).forEach((key) => {
        const value = String(replace[key]);

        if (value === null) {
            console.error(`Translation '${translation}' for key '${key}' contains a null replacement.`);

            return;
        }

        const searches = [':' + key, ':' + key.toUpperCase(), ':' + key.charAt(0).toUpperCase() + key.slice(1)];

        const replacements = [value, value.toUpperCase(), value.charAt(0).toUpperCase() + value.slice(1)];

        for (let i = searches.length - 1; i >= 0; i--) {
            translation = translation.replace(searches[i], replacements[i]);
        }
    });

    return translation;
}
