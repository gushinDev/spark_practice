<?php

$routes = [
  '' => 'app/Users/Controllers/UsersController@index',
  'users' => 'app/Users/Controllers/UsersController@index',
  'users\/(\d+)' => 'app/Users/Controllers/UsersController@findUser',
  'users\/create' => 'app/Users/Controllers/UsersController@createUser',
  'users\/(\d+)\/delete' => 'app/Users/Controllers/UsersController@deleteUser',
  'users\/(\d+)\/update' => 'app/Users/Controllers/UsersController@updateUser',
  'users\/(\d+)\/update_password' => 'app/Users/Controllers/UsersController@updatePassword',
  'login' => 'app/Access/Controllers/AccessController@login',
  'registration' => 'app/Access/Controllers/AccessController@registration',
  'logout' => 'app/Access/Controllers/AccessController@logout',
  'profile' => 'app/Users/Controllers/UsersController@userProfile',
  'courses' => 'app/Courses/Controllers/CoursesController@index',
  'courses\/(\d+)\/delete' => 'app/Courses/Controllers/CoursesController@deleteCourse',
  'courses\/create' => 'app/Courses/Controllers/CoursesController@createCourse',
  'courses\/(\d+)' => 'app/Courses/Controllers/CoursesController@readCourse',
  'courses\/(\d+)\/add_section' => 'app/Courses/Controllers/CoursesController@addSection',
  'courses\/(\d+)\/update' => 'app/Courses/Controllers/CoursesController@updateCourse',
  'courses\/catalog' => 'app/Courses/Controllers/CoursesController@allCourses',
  'courses\/(\d+)\/sections\/([a-zA-Z0-9]+)\/delete' => 'app/Courses/Controllers/CoursesController@deleteSection',
  'courses\/(\d+)\/sections\/([a-zA-Z0-9]+)\/update' => 'app/Courses/Controllers/CoursesController@updateSection',
];