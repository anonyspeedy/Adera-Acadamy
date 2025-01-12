<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adera-Acadamy</title>
    <link rel="stylesheet" href="css/home.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    <header>
        <a href="#" class="logo">Adera-Acadamy</a>
        <nav>
            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#courses">Courses</a>
                <a href="#about">About Us</a>
                <a href="#contact">Contact</a>
                <a href="login.php" class="btn-login">Login</a>
                <a href="register.php" class="btn-register">Register</a>
            </div>
        </nav>
    </header>

    <section class="video-background">
      <video autoplay loop muted playsinline>
          <source src="video/home.mp4" type="video/mp4">
          Your browser does not support the video tag.
      </video>
      <div class="hero">
          <div>
              <h1 id="typed-text">Welcome to Adera Acadamy</h1>
              <p>Unlock Your Potential with Our Interactive Courses</p>
              <a href="#courses">Explore Courses</a>
          </div>
      </div>
  </section>
  
  <script>
            const texts = [
                                 "Welcome to Adera Acadamy", 
                                 "Learn Coding", 
                                 "Learn Design", 
                                 "Master Data Science", 
                                 "Become a Web Developer"
                              ]; // Array with the text phrases
                              let textIndex = 0;
                              let charIndex = 0;
                              let isDeleting = false;
                              const typingSpeed = 150;
                              const deletingSpeed = 100;
                              const delayBetweenTexts = 2000;

                              const typedTextElement = document.getElementById("typed-text");
   
         function typeEffect() {
            const currentText = texts[textIndex];

            // Check if typing or deleting
            if (isDeleting) {
               typedTextElement.textContent = currentText.substring(0, charIndex--); // Typing backwards (deleting)
            } else {
               typedTextElement.textContent = currentText.substring(0, charIndex++); // Typing forwards (adding text)
            }

            // Handle completion of typing (before deletion starts)
            if (!isDeleting && charIndex === currentText.length) {
               // Wait for a moment after typing is complete before deleting starts
               setTimeout(() => {
                     isDeleting = true; // Start deleting after the delay
                     typeEffect(); // Call typeEffect again for deleting phase
               }, delayBetweenTexts);
            } else if (isDeleting && charIndex === 0) {
               // When text is completely deleted, move to next phrase
               setTimeout(() => {
                     isDeleting = false; // Start typing the next phrase
                     textIndex = (textIndex + 1) % texts.length; // Loop back to first phrase after last one
                     typeEffect(); // Start typing next phrase
               }, deletingSpeed);
            } else {
               // Continue typing or deleting with the appropriate speed
               setTimeout(typeEffect, isDeleting ? deletingSpeed : typingSpeed);
            }
         }

         document.addEventListener("DOMContentLoaded", typeEffect);



  </script>
  
  <section class="features" id="courses">
   <div class="container">
       <div class="row">
           <div class="col-md-4">
               <div class="feature-card">
                   <img src="images/instructors.jpeg" alt="Coding" class="feature-image">
                   <h3>Expert Instructors</h3>
                   <p>Learn from industry leaders with years of experience.</p>
               </div>
           </div>
           <div class="col-md-4">
               <div class="feature-card">
                   <img src="images/design.jpg" alt="Design" class="feature-image">
                   <h3>Flexible Learning</h3>
                   <p>Study at your own pace, anytime, anywhere.</p>
               </div>
           </div>
           <div class="col-md-4">
               <div class="feature-card">
                   <img src="images/certification.jpeg" alt="Data Science" class="feature-image">
                   <h3>Certifications</h3>
                   <p>Get certified and boost your career prospects.</p>
               </div>
           </div>
       </div>
   </div>
</section>
<section class="course-catalog" id="course-catalog">
   <div class="container">
       <h2>Course Catalog</h2>
       <div class="row">
           <div class="col-md-4">
               <div class="course-card">
                   <img src="images/python.jpg" alt="Python Programming" class="course-image">
                   <h3>Python Programming</h3>
                   <p>Learn the basics of Python programming.</p>
               </div>
           </div>
           <div class="col-md-4">
               <div class="course-card">
                   <img src="images/java.jpg" alt="Java Development" class="course-image">
                   <h3>Java Development</h3>
                   <p>Learn the basics of Java development.</p>
               </div>
           </div>
           <div class="col-md-4">
               <div class="course-card">
                   <img src="images/web-development.jpg" alt="Web Development" class="course-image">
                   <h3>Web Development</h3>
                   <p>Learn the basics of web development.</p>
               </div>
           </div>
       </div>
   </div>
</section>

    <section class="testimonials">
        <h2>What Our Students Say</h2>
        <div class="testimonial">
            "Adera-Acadamy has transformed my career! The courses are well-structured and easy to follow."
            <span>- Alex Johnson</span>
        </div>
        <div class="testimonial">
            "I love the flexibility of learning at my own pace. Highly recommended!"
            <span>- Maria Gomez</span>
        </div>
    </section>

    <section class="newsletter">
        <h2>Stay Updated</h2>
        <p>Subscribe to our newsletter to receive the latest updates and offers.</p>
        <form>
            <input type="email" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Adera-Acadamy. All rights reserved.</p>
    </footer>
</body>
</html>
