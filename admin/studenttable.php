<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searchable, Sortable Table with Pagination</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/tables.css">
</head>
<body>
  <div class="kabilogan"> 

  

  <button id="sortLastNameBtn">Sort by Last Name</button>


  <div class="pagination">
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Search table data...">
  </div>
  <div class="tablef"> 
    <label for="rowsPerPage">Show:</label>
    <select id="rowsPerPage">
      <option value="10">10</option>
      <option value="20">20</option>
      <option value="30">30</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>
    <button id="prevBtn">Previous</button>
    <span id="pageInfo">Page 1</span>
    <button id="nextBtn">Next</button>
  </div>
    
  </div>
  <div class="tabecon">
     <table id="dataTable">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Age</th>
        <th>Country</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <tr>
        <td data-label="First Name">Alice</td>
        <td data-label="Last Name">Johnson</td>
        <td data-label="Age">24</td>
        <td data-label="Country">USA</td>
      </tr>
      <tr>
        <td data-label="First Name">Bob</td>
        <td data-label="Last Name">Smith</td>
        <td data-label="Age">27</td>
        <td data-label="Country">Canada</td>
      </tr>
      <tr>
        <td data-label="First Name">Charlie</td>
        <td data-label="Last Name">Brown</td>
        <td data-label="Age">22</td>
        <td data-label="Country">UK</td>
      </tr>
      <tr>
        <td data-label="First Name">Diana</td>
        <td data-label="Last Name">Adams</td>
        <td data-label="Age">29</td>

        <td data-label="Country">Australia</td>
      </tr>
      <tr>
        <td data-label="First Name">Eve</td>
        <td data-label="Last Name">Clark</td>
        <td data-label="Age">21</td>
        <td data-label="Country">USA</td>
      </tr>
      <tr>
        <td data-label="First Name">Frank</td>
        <td data-label="Last Name">Wright</td>
        <td data-label="Age">30</td>
        <td data-label="Country">Canada</td>
      </tr>
      <tr>
        <td data-label="First Name">George</td>
        <td data-label="Last Name">Hall</td>
        <td data-label="Age">23</td>
        <td data-label="Country">UK</td>
      </tr>
      <tr>
        <td data-label="First Name">Hannah</td>
        <td data-label="Last Name">Baker</td>
        <td data-label="Age">25</td>
        <td data-label="Country">Australia</td>
      </tr>
      <tr>
        <td data-label="First Name">Ivy</td>
        <td data-label="Last Name">Lee</td>
        <td data-label="Age">28</td>
        <td data-label="Country">USA</td>
      </tr>
      <tr>
        <td data-label="First Name">Jack</td>
        <td data-label="Last Name">White</td>
        <td data-label="Age">26</td>
        <td data-label="Country">Canada</td>
      </tr>
      <tr>
        <td data-label="First Name">Kevin</td>
        <td data-label="Last Name">Black</td>
        <td data-label="Age">31</td>
        <td data-label="Country">UK</td>
      </tr>
      <tr>
        <td data-label="First Name">Luna</td>
        <td data-label="Last Name">Green</td>
        <td data-label="Age">20</td>
        <td data-label="Country">Australia</td>
      </tr>
      <tr>
        <td data-label="First Name">Mike</td>
        <td data-label="Last Name">Hill</td>
        <td data-label="Age">33</td>
        <td data-label="Country">USA</td>
      </tr>
      <tr>
        <td data-label="First Name">Nina</td>
        <td data-label="Last Name">Scott</td>
        <td data-label="Age">24</td>
        <td data-label="Country">Canada</td>
      </tr>
      <tr>
        <td data-label="First Name">Oscar</td>
        <td data-label="Last Name">Lopez</td>
        <td data-label="Age">32</td>
        <td data-label="Country">UK</td>
      </tr>
      <tr>
        <td data-label="First Name">Paul</td>
        <td data-label="Last Name">King</td>
        <td data-label="Age">29</td>
        <td data-label="Country">Australia</td>
      </tr>
      <tr>
        <td data-label="First Name">Quinn</td>
        <td data-label="Last Name">Evans</td>
        <td data-label="Age">19</td>
        <td data-label="Country">USA</td>
      </tr>
      <tr>
        <td data-label="First Name">Rachel</td>
        <td data-label="Last Name">Morris</td>
        <td data-label="Age">22</td>
        <td data-label="Country">Canada</td>
      </tr>
      <tr>
        <td data-label="First Name">Sam</td>
        <td data-label="Last Name">Nelson</td>
        <td data-label="Age">27</td>
        <td data-label="Country">UK</td>
      </tr>
      <tr>
        <td data-label="First Name">Tina</td>
        <td data-label="Last Name">Owens</td>
        <td data-label="Age">23</td>
        <td data-label="Country">Australia</td>
      </tr>
    </tbody>
  </table>
  </div>

 

  <script src="../assets/js/table.js">

  </script>
</div>
</body>
</html>
