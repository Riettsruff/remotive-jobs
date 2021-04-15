<?php

class RemotiveJobsAPI
{
  private static $URL = "https://remotive.io/api/remote-jobs";
  private static $LIMIT = 100;

  public static function getCategories()
  {
    $path = self::$URL . "/categories";
    $result = file_get_contents($path);

    return json_decode($result)->jobs;
  }

  public static function getAllJobs()
  {
    $path = self::$URL . "?limit=" . self::$LIMIT;
    $result = file_get_contents($path);

    return json_decode($result)->jobs;
  }

  public static function getJobsByCategory($category, $search = "")
  {
    $query = "?category=$category";
    if ($search) $query .= "&search=" . urlencode($search);
    $query .= "&limit=" . self::$LIMIT;

    $path = self::$URL . $query;
    $result = file_get_contents($path);

    return json_decode($result)->jobs;
  }

  public static function getJobsBySearch($search)
  {
    $path = self::$URL . "?search=$search";
    $result = file_get_contents($path);

    return json_decode($result)->jobs;
  }
}
