<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Submission | User feedback system</title>
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
    <div class="flex w-full bg-[url('images/mac2.jpg')] bg-cover bg-center h-[100vh] justify-center items-center">
        <div class="w-[450px] p-[30px] bg-transparent border-solid borderwhite rounded-[20px] border-[3px] backdrop-blur-md">
            <p class="text-start font-bold text-[20px] text-white uppercase">Thanks for submitting your feedback</p>
            <a href="index.php">
                <button class="w-full pr-[20px] pl-[20px] pt-[10px] pb-[10px] rounded-full text-[#000] bg-white outline-none">Go home</button>
            </a>
        </div>
    </div>

    
</body>
</html>