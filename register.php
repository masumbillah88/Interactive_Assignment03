<?php
require_once 'Users.php';
require 'helpers.php';
session_start();
//Created an instance of helpers class to access the sanitize method.
$helpers = new Helpers();

//Created an error bag to store all the error message here.
$errors = [];
$userName = '';
$email = '';
$password = '';
$confirm_password = '';
if($_SERVER['REQUEST_METHOD']==="POST"){
    if(empty($_POST['name'])){
        $errors['name'] = "*Please provide a name.";
    }else{
        $userName = $helpers->sanitize($_POST['name']);
    }
    if(empty($_POST['email'])){
        $errors['email'] = "*Please provide a valid email.";
    }else if(!$helpers->validateEmail($_POST['email'])){
        $errors['email_validation']= "Valid Email required";
        
        
    }else{
        $email = $helpers->validateEmail($_POST['email']);
    }
    if(empty($_POST['password'])){
        $errors['password'] = "* Please provide a strong password.";
    }else{
        $password = $helpers->sanitize($_POST['password']);
    }
    if(empty($_POST['confirm_password'])){
        $errors['confirm_password'] = "* Please provide a strong password.";
    }else{
        $confirm_password = $helpers->sanitize($_POST['confirm_password']);
        
        
    }
    if($confirm_password !== $password){
        $errors['password_mismatch'] = " Password does not match. ";
        header("Location: register.php");
        exit();
    }
    
    
  
    
    try{
        $user = new Users();
        
            $user->register($userName,$email,$password);
            $_SESSION['flash_message'] = "Registered Successfully";
            header("Location:login.php");
            exit();
        
      
        

    }catch(Exception $e){
        $error = $e->getMessage();
    }     
    

    
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TruthWhisper - Anonymous Feedback App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<header class="bg-white">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="./index.html" class="-m-1.5 p-1.5">
                <span class="sr-only">TruthWhisper</span>
                <span class="block font-bold text-lg bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</span>
            </a>
        </div>
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            <a href="./login.php" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="./index.php" class="-m-1.5 p-1.5">
                    <span class="sr-only">Shahriar Masum</span>
                    <span class="block font-bold text-xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">Shahriar Masum</span>
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="py-6">
                        <a href="./login.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <img src="./images/beams.jpg" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
        <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
            <div class="mx-auto max-w-xl">
                <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                    <div class="mx-auto w-full max-w-xl text-center px-24">
                        <h1 class="block text-center font-bold text-2xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">Shahriar Masum</h1>
                    </div>

                    <div class="mt-10 mx-auto w-full max-w-xl">
                        <form class="space-y-6" action="register.php" method="POST">
                            <div>
                                <?php if(isset($errors['name'])): ?>
                                    <p class="text-xs text-red-600 mt-2" id="name-error"><?= $errors['name']; ?></p>
                                <?php endif; ?>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                                <div class="mt-2">
                                    <input id="name" name="name" type="text"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                            <?php if(isset($errors['email_validation'])): ?>
                                    <p class="text-xs text-red-600 mt-2" id="name-error"><?= $errors['email_validation']; ?></p>
                                <?php endif; ?>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                                <div class="mt-2">
                                    <input id="email" name="email"  autocomplete="email"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                            <?php if(isset($errors['password'])): ?>
                                    <p class="text-xs text-red-600 mt-2" id="name-error"><?= $errors['password']; ?></p>
                                <?php endif; ?>
                                <div class="flex items-center justify-between">
                                    <!-- // -->
                                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" autocomplete="current-password"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                                </div>
                                
                                <div class="mt-2">
                                    <input id="confirm_password" name="confirm_password" type="password"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <?php if(isset($errors['password_mismatch'])): ?>
                                    <p class="text-xs text-red-600 mt-2" id="name-error"><?= $errors['password_mismatch']; ?></p>
                                <?php endif; ?>
                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                            </div>
                        </form>
                        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

                        <p class="mt-10 text-center text-sm text-gray-500">
                            Already have an account?
                            <a href="./login.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login!</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center justify-center lg:px-8">
        <p class="text-center text-xs leading-5 text-gray-500">&copy; 2024 TruthWhisper, Inc. All rights reserved.</p>
    </div>
</footer>

</body>
</html>