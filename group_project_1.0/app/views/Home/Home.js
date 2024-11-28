// JavaScript to trigger the animations on scroll
document.addEventListener('scroll', function() {
  const features = document.querySelectorAll('.features-container .feature');

  features.forEach((feature) => {
    // Get the position of the feature relative to the viewport
    const rect = feature.getBoundingClientRect();

    // Check if the feature is within the viewport
    if (rect.top >= 0 && rect.top <= window.innerHeight) {
      feature.classList.add('visible');
      feature.classList.remove('hidden');
    } else {
      feature.classList.add('hidden');
      feature.classList.remove('visible');
    }
  });
});

// Initialize animation when the page loads
window.addEventListener('load', function() {
  const features = document.querySelectorAll('.features-container .feature');
  
  features.forEach((feature) => {
    feature.classList.add('hidden');
  });
});

// JavaScript to trigger the animation when the element is in the viewport
document.addEventListener('scroll', function() {
  const benefits = document.querySelectorAll('.benefits-container .benefit');

  benefits.forEach((benefit) => {
    // Get the position of the element relative to the viewport
    const rect = benefit.getBoundingClientRect();

    // Check if the element is in the viewport
    if (rect.top >= 0 && rect.top <= window.innerHeight) {
      benefit.classList.add('visible');
    } else {
      benefit.classList.remove('visible');
    }
  });
});

// Initialize the elements with the hidden class
window.addEventListener('load', function() {
  const benefits = document.querySelectorAll('.benefits-container .benefit');
  benefits.forEach((benefit) => {
    benefit.classList.add('hidden');
  });
});
