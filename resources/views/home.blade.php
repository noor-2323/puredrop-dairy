<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureDrop Dairy</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="header">
        <div class="container nav">
            <h2 class="logo">PureDrop Dairy</h2>
            <nav>
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container">
                <p class="tagline">Freshness You Can Trust</p>
                <h1>Welcome to PureDrop Dairy</h1>
                <p>Fresh dairy products and reliable service for every customer.</p>
                <a class="btn" href="#contact">Contact Us</a>
            </div>
        </section>

        <section class="about container" id="about">
            <h2>About PureDrop Dairy</h2>
            <p>We deliver fresh dairy products and excellent customer service to our community.</p>
        </section>

        <section class="contact container" id="contact">
            <h2>Get in Touch</h2>
            <p>Send us a message and our team will contact you.</p>

  @if (session()->has('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif  
 <form method="POST" action="/contact">
                @csrf
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Write your message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} PureDrop Dairy. All rights reserved.</p>
    </footer>
</body>
</html>