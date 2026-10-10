export function readUrlParams() {
    const p = new URLSearchParams(window.location.search);
    return {
        country:     p.get('country')     || null,
        language:    p.get('lang')        || null,
        type:        p.get('type')        || null,
        subdivision: p.get('subdivision') || null,
        year:        p.get('year')        ? parseInt(p.get('year'), 10) : null,
    };
}

export function writeUrlParams({ country, language, type, subdivision, year }) {
    const p = new URLSearchParams();
    if (country)     p.set('country', country);
    if (language)    p.set('lang', language);
    if (type)        p.set('type', type);
    if (subdivision) p.set('subdivision', subdivision);
    if (year)        p.set('year', year);
    history.replaceState(null, '', `?${p.toString()}`);
}
