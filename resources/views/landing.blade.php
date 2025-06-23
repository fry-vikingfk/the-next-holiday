<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upcoming Holidays</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #6bc7a8;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 4rem 1.5rem;
      min-height: 100vh;
    }

    h1 {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 3rem;
      text-align: center;
    }

    .hero {
      text-align: center;
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 3rem;
      line-height: 1.4;
      color: #ffffff;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 2rem;
      max-width: 900px;
      width: 100%;
      text-align: center;
      margin-bottom: 3rem;
    }

    .grid div {
      font-size: 1.2rem;
      font-weight: 500;
      transition: transform 0.3s ease;
    }

    .grid div:hover {
      transform: scale(1.05);
    }

    .grid div:nth-of-type(1) {
      color: #f0fefb;
    }

    .grid div:nth-of-type(2),
    .grid div:nth-of-type(3) {
      color: #cceee3;
    }

    .grid small {
      display: block;
      margin-top: 0.4rem;
      font-size: 0.95rem;
      color: #cceee3;
    }

    .pagination {
      display: flex;
      gap: 1.2rem;
      margin-top: 2rem;
    }

    .pagination button {
      background-color: transparent;
      color: #ffffff;
      border: 2px solid #ffffff;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .pagination button:hover:not(:disabled) {
      background-color: #ffffff;
      color: #6bc7a8;
    }

    .pagination button:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    @media (max-width: 600px) {
      .hero {
        font-size: 1.6rem;
      }

      .grid div {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <h1>Next Public Holidays</h1>

  <section class="hero" id="mainHoliday">Loading...</section>

  <section class="grid" id="otherHolidays"></section>

  <div class="pagination">
    <button id="prevBtn" disabled>Prev</button>
    <button id="nextBtn" disabled>Next</button>
  </div>

  <script type="module">
    let currentPage = 1;

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const mainHoliday = document.getElementById('mainHoliday');
    const otherHolidays = document.getElementById('otherHolidays');

    const loadHolidays = async (page = 1) => {
      try {
        const res = await fetch(`/api/holidays/public?page=${page}&perPage=4`);
        const { data = [], meta, links } = await res.json();

        if (data.length) {
          const [first, ...rest] = data;

          mainHoliday.innerHTML = `
            <strong>${first.name?.[0]?.text ?? 'Unnamed'}</strong><br>
            <small>${first.startDate}</small>
          `;

          otherHolidays.innerHTML = rest.map(({ name, startDate }) => `
            <div>
              <strong>${name?.[0]?.text ?? 'Unnamed'}</strong>
              <small>${startDate}</small>
            </div>
          `).join('');
        } else {
          mainHoliday.textContent = 'No holidays found.';
          otherHolidays.innerHTML = '';
        }

        currentPage = meta?.current_page ?? 1;
        prevBtn.disabled = !links?.prev;
        nextBtn.disabled = !links?.next;

      } catch (error) {
        console.error('Error fetching holidays:', error);
        mainHoliday.textContent = 'Error loading holidays.';
        otherHolidays.innerHTML = '';
      }
    };

    prevBtn?.addEventListener('click', () => {
      if (currentPage > 1) loadHolidays(currentPage - 1);
    });

    nextBtn?.addEventListener('click', () => {
      loadHolidays(currentPage + 1);
    });

    loadHolidays();
  </script>
</body>
</html>
