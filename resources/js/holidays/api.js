export async function fetchUserCountry() {
    const res = await fetch('/api/user-country');
    return await res.json();
}

export async function fetchLanguages() {
    const res = await fetch('/api/languages');
    const { data = [] } = await res.json();
    return data;
}

export async function fetchCountries(language) {
    const res = await fetch(`/api/countries?languageIsoCode=${language}`);
    const { data = [] } = await res.json();
    return data;
}

export async function fetchSubdivisions(country, language) {
    const res = await fetch(`/api/subdivisions?countryIsoCode=${country}&languageIsoCode=${language}`);
    const { data = [] } = await res.json();
    return data;
}

export async function fetchHolidays(type, country, language, subdivision, year) {
    const currentYear = new Date().getFullYear();
    const today = new Date().toISOString().slice(0, 10);
    const validFrom = year === currentYear ? today : `${year}-01-01`;
    const validTo = `${year}-12-31`;

    const params = new URLSearchParams({
        countryIsoCode: country,
        languageIsoCode: language,
        validFrom,
        validTo,
        perPage: 100,
    });

    if (subdivision) params.set('subdivisionCode', subdivision);

    const res = await fetch(`/api/holidays/${type}?${params}`);
    const { data = [] } = await res.json();
    return data;
}
