<?php
require_once("php/main.php");

if (isset($_GET["category"])) {
  if (isset($_GET["search"])) {
    $jobs = RemotiveJobsAPI::getJobsByCategory($_GET["category"], $_GET["search"]);
  } else {
    $jobs = RemotiveJobsAPI::getJobsByCategory($_GET["category"]);
  }
} else {
  if (isset($_GET["search"])) {
    $jobs = RemotiveJobsAPI::getJobsBySearch($_GET["search"]);
  } else {
    $jobs = RemotiveJobsAPI::getAllJobs();
  }
}

$categories = RemotiveJobsAPI::getCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Remotive Jobs</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <div id="header">
    <h1 class="main-title">Remotive Jobs</h1>
    <p class="greeting-text">Ready to Work?</p>
    <div class="bottom-of-header">
      <div class="category-area">
        <div class="single-category<?= isset($_GET["category"]) || isset($_GET["search"]) ? "" : " active"; ?>">
          <a class="single-category-link" href="<?= $_SERVER["PHP_SELF"]; ?>">All Categories</a>
        </div>
        <?php foreach ($categories as $category) { ?>
          <div class="single-category<?= isset($_GET["category"]) && $_GET["category"] == $category->slug ? " active" : ""; ?>">
            <a class="single-category-link" href="<?= "?category=" . $category->slug; ?>"><?= $category->name; ?></a>
          </div>
        <?php } ?>
      </div>
      <div class="search-area">
        <form id="search-jobs-form">
          <?php if (isset($_GET["category"])) { ?>
            <input type="hidden" name="category" value="<?= $_GET["category"]; ?>" />
          <?php } ?>
          <input type="text" class="form-control" name="search" id="search_jobs__text" value="<?= isset($_GET["search"]) ? $_GET["search"] : ""; ?>" autocomplete="off" placeholder="By title & description..." required />
          <button type="submit" class="submit-button">Search</button>
        </form>
      </div>
    </div>
  </div>
  <div id="main-content">
    <div class="main-content-header">
      <p class="category-content-title">
        <?php
        if (isset($_GET["category"])) {
          $keyTarget = array_search($_GET["category"], array_column($categories, "slug"));
          if ($keyTarget !== false) {
            echo $categories[$keyTarget]->name;
          }
        } else {
          echo "All Categories";
        }
        ?>
      </p>
      <div class="search-content-title">
        <?php if (isset($_GET["search"])) { ?>
          <span class="search-content-title-text">Search Results from </span>
          <span class="search-content-title-value">"<?= $_GET["search"]; ?>"</span>
        <?php } ?>
      </div>
    </div>
    <div class="main-content-body row">
      <?php foreach ($jobs as $job) { ?>
        <div class="single-content-wrapper col-lg-3 col-md-4 col-sm-6">
          <div class="single-content">
            <span class="publication-date"><?= substr($job->publication_date, 0, 10); ?></span>
            <p class="title"><?= $job->title; ?></p>
            <div class="category-wrapper">
              <span class="category"><?= $job->category; ?></span>
            </div>
            <p class="company-name"><?= $job->company_name; ?></p>
            <div class="view-detail-button" data-title="<?= $job->title; ?>" data-company-name="<?= $job->company_name; ?>" data-publication-date="<?= $job->publication_date; ?>" data-job-type="<?= $job->job_type; ?>" data-hiring-from="<?= $job->candidate_required_location; ?>" data-salary="<?= $job->salary; ?>" data-description="<?= htmlentities($job->description); ?>">
              <span class="view-detail-button-text">View Detail</span>
            </div>
            <div class="get-job-link-button">
              <a href="<?= $job->url; ?>" target="_blank">
                <span class="get-job-link-button-text">Get Job Link</span>
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div id="detail-main-content">
    <div class="detail-box">
      <span class="close-button">&times;</span>
      <p class="job-title">Software Engineer</p>
      <p class="company-name">Amplified IT</p>
      <div class="info-content">
        <p class="publication-date">2021-04-05</p>
        <p class="job-type">
          <span class="job-type-label">Job Type</span>
          <span class="job-type-value">Full-time</span>
        </p>
        <p class="hiring-from">
          <span class="hiring-from-label">Hiring From</span>
          <span class="hiring-from-value">USA Only</span>
        </p>
        <p class="salary">
          <span class="salary-label">Salary</span>
          <span class="salary-value">$5000 - $10000</span>
        </p>
      </div>
      <div class="description-content">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae impedit ducimus placeat assumenda at molestias! Unde sint ducimus dolore amet! Consequuntur commodi molestiae illo! Tempore quis corrupti nulla reiciendis aut!</p>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>