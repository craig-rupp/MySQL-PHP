<?php
require __DIR__ . '/../src/Input.php';

function pageController()
{
    $sql_command = "SELECT * from teams";
    // $page = '';    
    if (Input::has('team_or_stadium')) {
    // Concatenate the WHERE clause that filters the teams by similar names
    // or stadiums
    $team_stadium = Input::get('team_or_stadium');
    // Write the query to retrieve the details of all of the teams
    $sql_command .= " WHERE name LIKE '%$team_stadium%' or stadium LIKE '%$team_stadium'";
    }
    
    if (Input::has('sort_by')) {
    // Concatenate the WHERE clause that orders the teams by name, league or
    // stadium.
    $sort_this = Input::get('sort_by');
    $sql_command .= " ORDER by $sort_this";
    }

    // if(Input::get('page', 1)){
    //   $page = 0;
    // } else{
    //   $page = Input::get('page') * 5 -5;

    // }
    $page = Input::get('page', 1) < 0 ? 1 : Input::get('page');
    $offset = $page * 5 - 5;
    $sql_command .= " LIMIT 5 OFFSET $offset";

    // if (Input::has('page')) {
    // $page = Input::get('page', 1);
    // $limit = 5;
    // $offset = ($page - 1) * $limit;
    // Add a LIMIT and an OFFSET clause, suppose the size of each page is 5
    // Copy the query and test it in SQL Pro
    var_dump($sql_command);

    return [
        'title' => 'Teams',
        'page' => $offset
    ];
}
extract(pageController());
?>
<!DOCTYPE html>
<html>
<head>
    <?php include '../partials/head.phtml' ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <header class="page-header">
                <h1>Teams</h1>
            </header>
        </div>
        <div class="col-md-4" style="padding-top: 3.5em">
            <form class="form-inline" method="get">
                <div class="form-group">
                    <input
                        type="text"
                        class="form-control"
                        id="team"
                        name="team_or_stadium"
                        placeholder="Team or Stadium">
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search" aria-hidden="true">
                    </span>
                    Search
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <form method="post" action="delete-teams.php">
          <table class="table table-striped table-hover table-bordered">
              <thead>
              <tr>
                  <th>Delete</th>
                  <th>
                      <a href="?sort_by=team">Team</a>
                  </th>
                  <th>
                      <a href="?sort_by=stadium">Stadium</a>
                  </th>
                  <th>
                      <a href="?sort_by=league">League</a>
                  </th>
              </tr>
              </thead>
              <tbody>
              <tr>
                  <td>
                      <input type="checkbox" name="teams[]" value="1">
                  </td>
                  <td>
                      <a href="team-details.php?team_id=1">
                          Red Sox
                      </a>
                  </td>
                  <td>Fenway Park</td>
                  <td>American</td>
              </tr>
              <tr>
                  <td>
                      <input type="checkbox" name="teams[]" value="3">
                  </td>
                  <td>
                      <a href="team-details.php?team_id=3">
                          Seattle Mariners
                      </a>
                  </td>
                  <td>Safeco Field</td>
                  <td>American</td>
              </tr>
              <tr>
                  <td>
                      <input type="checkbox" name="teams[]" value="2">
                  </td>
                  <td>
                      <a href="team-details.php?team_id=2">
                          Texas Rangers
                      </a>
                  </td>
                  <td>Global Life Park</td>
                  <td>American</td>
              </tr>
              <tr>
                  <td>
                      <input type="checkbox" name="teams[]" value="4">
                  </td>
                  <td>
                      <a href="team-details.php?team_id=1">
                          Chicago Cubs
                      </a>
                  </td>
                  <td>Wrigley Field</td>
                  <td>National</td>
              </tr>
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="4">
                        <!-- The values in this pagination control indicate you're currently viewing page 2 -->
                        <nav aria-label="Page navigation" class="text-center">
                            <ul class="pagination">
                                <li>
                                    <a href="?page=<? $offset - 1?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="?page=1">1</a></li>
                                <li><a href="?page=2">2</a></li>
                                <li><a href="?page=3">3</a></li>
                                <li><a href="?page=4">4</a></li>
                                <li><a href="?page=5">5</a></li>
                                <li>
                                    <a href="?page=<? $page +1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </td>
                </tr>
              </tfoot>
            </table>
            <button type="submit" class="btn btn-danger">
                <span class="glyphicon glyphicon-trash"></span>
                Delete
            </button>
            <a href="new-team.php" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>
                Add a new team
            </a>
        </form>
    </div>
</div>