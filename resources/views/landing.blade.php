<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Holidays</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Anton&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data='holidayApp(@json($translations))' x-init="init()">

    <div class="container">

        {{-- Topbar --}}
        <div class="topbar">
            <h1 @click="window.location.reload()">Next Holidays</h1>

            <div class="dropdowns">

                {{-- Country --}}
                <select x-model="country" @change="onCountryChange()">
                    <template x-for="c in countries" :key="c.isoCode">
                        <option :value="c.isoCode" x-text="countryName(c)"></option>
                    </template>
                </select>

                {{-- Subdivision --}}
                <select x-show="hasSubdivisions" x-model="subdivision" @change="loadHolidays()">
                    <option value="" x-show="type === 'public'" x-text="__('all-regions')"></option>
                    <template x-for="s in subdivisions" :key="s.code">
                        <option :value="s.code" x-text="subdivisionName(s)"></option>
                    </template>
                </select>

                {{-- Language --}}
                <select x-model="language" @change="onLanguageChange()">
                    <template x-for="l in languages" :key="l.isoCode">
                        <option :value="l.isoCode" x-text="langName(l)"></option>
                    </template>
                </select>

                {{-- Holiday type --}}
                <select x-model="type" @change="onTypeChange()">
                    <option value="public" x-text="__('public')"></option>
                    <option value="school" x-text="__('school')"></option>
                </select>

                <div class="year-nav">
                    <button class="year-btn" @click="prevYear()" aria-label="Previous year">&#8592;</button>
                    <span class="year-label" x-text="year"></span>
                    <button class="year-btn" @click="nextYear()" aria-label="Next year">&#8594;</button>
                </div>

            </div>
        </div>

        {{-- Hero card --}}
        <div class="hero-card">

            {{-- Loading state --}}
            <div id="mainHoliday">
                <span x-show="loading" class="loading">&#9679;&#9679;&#9679;</span>

                <template x-if="!loading && needsSubdivision">
                    <span x-text="__('please-select-a-region-for-school-holidays')"></span>
                </template>

                <template x-if="!loading && !needsSubdivision && !heroHoliday">
                    <span x-text="__('no-holidays-found')"></span>
                </template>

                <template x-if="!loading && heroHoliday">
                    <span x-text="holidayName(heroHoliday).toUpperCase()"></span>
                </template>
            </div>

            {{-- Hero meta: type + date --}}
            <div id="mainType" x-show="!loading && heroHoliday">
                <span x-text="heroHoliday ? __(heroHoliday.type?.toLowerCase()).toUpperCase() : ''"></span>
                <small x-text="heroHoliday ? formatDateRange(heroHoliday.startDate, heroHoliday.endDate) : ''"></small>
            </div>

            <div x-show="!loading && heroHoliday && countdown(heroHoliday?.startDateIso)">
                <span class="countdown-badge" x-text="countdown(heroHoliday?.startDateIso)"></span>
            </div>

        </div>

        {{-- Upcoming holidays grid --}}
        <div class="section-title" x-show="!loading && upcomingHolidays.length > 0" x-text="sectionTitle"></div>

        <div class="others">
            <template x-for="holiday in upcomingHolidays" :key="holiday.startDate + holidayName(holiday)">
                <div class="holiday-card">
                    <div class="holiday-card-name" x-text="holidayName(holiday)"></div>
                    <div class="holiday-card-date" x-text="formatDateRange(holiday.startDate, holiday.endDate)"></div>
                </div>
            </template>
        </div>

    </div>

</body>
</html>
