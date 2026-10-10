import {
    fetchUserCountry,
    fetchLanguages,
    fetchCountries,
    fetchSubdivisions,
    fetchHolidays,
} from './api.js';

import { readUrlParams, writeUrlParams } from './url.js';

const currentYear = new Date().getFullYear();

export function holidayApp(translations) {
    return {
        translations,

        country: 'IE',
        language: 'EN',
        type: 'public',
        subdivision: null,
        year: currentYear,
        loading: false,

        countries: [],
        languages: [],
        subdivisions: [],
        holidays: [],

        // ── Helpers ─────────────────────────────────────────

        __(key) {
            return this.translations[this.language]?.[key] ?? key;
        },

        localeName(items, lang) {
            const names = items ?? [];
            return names.find(n => n.language === lang)?.text ?? names[0]?.text ?? '';
        },

        countryName(c) {
            return this.localeName(c.name, this.language) || c.isoCode;
        },

        langName(l) {
            return this.localeName(l.name, this.language) || l.isoCode;
        },

        subdivisionName(s) {
            return this.localeName(s.name, this.language) || s.code;
        },

        holidayName(h) {
            return this.localeName(h.name, this.language) || this.__('unnamed');
        },

        formatDateRange(start, end) {
            if (!start) return '';
            if (!end || start === end) return start;
            return `${start} – ${end}`;
        },

        countdown(startDateIso) {
            if (!startDateIso) return '';
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const start = new Date(`${startDateIso}T00:00:00`);
            const days = Math.round((start - today) / 86_400_000);
            if (days < 0) return '';
            if (days === 0) return this.__('today') || 'Today!';
            return `${this.__('in') || 'in'} ${days} ${days === 1 ? (this.__('day') || 'day') : (this.__('days') || 'days')}`;
        },

        get heroHoliday() {
            return this.holidays[0] ?? null;
        },

        get upcomingHolidays() {
            return this.holidays.slice(1);
        },

        get hasSubdivisions() {
            return this.subdivisions.length > 0;
        },

        get needsSubdivision() {
            return this.type === 'school' && this.hasSubdivisions && !this.subdivision;
        },

        get sectionTitle() {
            const base = this.__('upcoming-holidays') || 'Upcoming Holidays';
            return this.year !== currentYear ? `${base} — ${this.year}` : base;
        },

        // ── Data loading ─────────────────────────────────────

        async loadLanguages() {
            try {
                this.languages = await fetchLanguages();
            } catch (e) {
                console.error('Failed to load languages', e);
            }
        },

        async loadCountries() {
            try {
                this.countries = await fetchCountries(this.language);
            } catch (e) {
                console.error('Failed to load countries', e);
            }
        },

        async loadSubdivisions(preserveSelection = false) {
            const prev = preserveSelection ? this.subdivision : null;
            this.subdivision = null;
            this.subdivisions = [];

            try {
                const data = await fetchSubdivisions(this.country, this.language);
                this.subdivisions = data;
                if (prev && data.some(s => s.code === prev)) {
                    this.subdivision = prev;
                }
            } catch (e) {
                console.error('Failed to load subdivisions', e);
            }
        },

        async loadHolidays() {
            this.loading = true;
            this.holidays = [];

            try {
                if (!this.needsSubdivision) {
                    this.holidays = await fetchHolidays(
                        this.type,
                        this.country,
                        this.language,
                        this.subdivision,
                        this.year,
                    );
                }
            } catch (e) {
                console.error('Failed to load holidays', e);
            } finally {
                this.loading = false;
                writeUrlParams(this);
            }
        },

        // ── Event handlers ───────────────────────────────────

        async onLanguageChange() {
            await Promise.all([this.loadCountries(), this.loadSubdivisions(true)]);
            await this.loadHolidays();
        },

        async onCountryChange() {
            await this.loadSubdivisions();
            await this.loadHolidays();
        },

        async onTypeChange() {
            if (this.type === 'public') this.subdivision = null;
            await this.loadHolidays();
        },

        async prevYear() {
            this.year--;
            await this.loadHolidays();
        },

        async nextYear() {
            this.year++;
            await this.loadHolidays();
        },

        // ── Init ─────────────────────────────────────────────

        async init() {
            const params = readUrlParams();
            if (params.language) this.language = params.language;
            if (params.type) this.type = params.type;
            if (params.year) this.year = params.year;

            // URL param wins over IP geo-detection
            if (params.country) {
                this.country = params.country;
                if (params.subdivision) this.subdivision = params.subdivision;
            } else {
                try {
                    const geo = await fetchUserCountry();
                    if (geo.detected && geo.countryCode) this.country = geo.countryCode;
                } catch (e) {
                    // keep default
                }
            }

            await Promise.all([
                this.loadLanguages(),
                this.loadCountries(),
                this.loadSubdivisions(!!params.subdivision),
            ]);
            await this.loadHolidays();
        },
    };
}
