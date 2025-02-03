const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const sortLastNameBtn = document.getElementById('sortLastNameBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');

    let currentPage = 1;
    let sorted = false;
    let rowsPerPage = localStorage.getItem('rowsPerPage') || 10; // Load from localStorage

    rowsPerPageSelect.value = rowsPerPage; // Set the select input

    const data = Array.from(tableBody.rows).map(row => ({
      firstName: row.cells[0].innerText,
      lastName: row.cells[1].innerText,
      age: parseInt(row.cells[2].innerText),
      country: row.cells[3].innerText,
    }));

    function renderTable() {
      const startIndex = (currentPage - 1) * rowsPerPage;
      const endIndex = startIndex + rowsPerPage;

      const filteredData = data.filter(person =>
        Object.values(person).some(val =>
          val.toString().toLowerCase().includes(searchInput.value.toLowerCase())
        )
      );

      const paginatedData = sorted
        ? filteredData.sort((a, b) => a.lastName.localeCompare(b.lastName))
        : filteredData;

      tableBody.innerHTML = paginatedData
        .slice(startIndex, endIndex)
        .map(person =>
          `<tr>
            <td>${person.firstName}</td>
            <td>${person.lastName}</td>
            <td>${person.age}</td>
            <td>${person.country}</td>
          </tr>`
        )
        .join('');

      pageInfo.textContent = `Page ${currentPage} of ${Math.ceil(filteredData.length / rowsPerPage)}`;
      prevBtn.disabled = currentPage === 1;
      nextBtn.disabled = currentPage === Math.ceil(filteredData.length / rowsPerPage);
    }

    rowsPerPageSelect.addEventListener('change', () => {
      rowsPerPage = Number(rowsPerPageSelect.value);
      localStorage.setItem('rowsPerPage', rowsPerPage); // Save to localStorage
      currentPage = 1;
      renderTable();
    });

    searchInput.addEventListener('input', renderTable);

    sortLastNameBtn.addEventListener('click', () => {
      sorted = !sorted;
      renderTable();
    });

    prevBtn.addEventListener('click', () => {
      if (currentPage > 1) currentPage--;
      renderTable();
    });

    nextBtn.addEventListener('click', () => {
      currentPage++;
      renderTable();
    });

    renderTable();