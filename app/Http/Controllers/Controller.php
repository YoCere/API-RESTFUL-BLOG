<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="API RESTFUL BLOG",
 *     version="1.0.0",
 *     description="API RESTful for managing articles, categories, users, and comments",
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header",
 *     name="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * ),
 */
abstract class Controller
{
    //
}
