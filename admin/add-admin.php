<?php
    session_start();
    
    $user = $_SESSION['id'];

    if (!$user) {
        header('location: ../index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add admin | User feedback system</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            screens: {
                sm: '640px',
                
                md: '784px',
                
                lg: '1024px',
                
                xl: '1280px',
            },
            extend: {
            }
          }
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
</head>
<body>
    <div class="flex w-full bg-[url('mac2.jpg')] bg-cover bg-center h-[100vh] justify-center items-center">
        <div class="w-[450px] p-[30px] bg-transparent border-solid borderwhite rounded-[20px] border-[3px] backdrop-blur-md">
            <p class="text-start font-bold text-[20px] text-white uppercase">Add an admin</p>
            <p class="text-start text-white mt-[20px]">This page is made for only admins to add admins.</p>
            <!-- form -->
             <div class="mt-[15px]">
                <form action='../includes/add_admin_inc.php' method='POST' class="flex flex-col space-y-[20px]">
                    <input type='text' class="outline-none text-white border-solid border-white/[80%] border-b-[2px] focus:border-white bg-transparent w-full placeholder:text-white/[50%]" name="name" placeholder="Name" />
                    <input type='email' class="outline-none text-white border-solid border-white/[80%] border-b-[2px] focus:border-white bg-transparent w-full placeholder:text-white/[50%]" name="email" placeholder="Email" />
                    <input type='password' class="outline-none text-white border-solid border-white/[80%] border-b-[2px] focus:border-white bg-transparent w-full placeholder:text-white/[50%]" name="password" placeholder="Password" />
                    <button type='submit' name='add-admin-btn' class="w-full pr-[20px] pl-[20px] pt-[10px] pb-[10px] rounded-full text-[#000] bg-white outline-none">Add admin</button>
                </form>
             </div>
            <!-- form -->
        </div>
    </div>

    
</body>
</html>