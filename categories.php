<?php
// inc/categories.php - centralized category definitions for KindConnect
// Each category has: title, short (1-line summary), description (HTML allowed), image (relative to public/assets/images)
$categories = [
  'plumber' => [
    'title' => 'Plumber',
    'short' => 'Fix leaks, unclog drains, and handle pipe emergencies.',
    'description' => '<p>Qualified local plumbers offering residential repairs, emergency fixes, and preventative maintenance.</p><ul><li>Leak repairs</li><li>Drain cleaning</li><li>Tap and fixture replacement</li></ul>',
    'image' => 'plumber.webp',
  ],
  'electrician' => [
    'title' => 'Electrician',
    'short' => 'Wiring, switches, sockets and electrical safety checks.',
    'description' => '<p>Certified electricians for installations, fault-finding, and safety inspections.</p><ul><li>Lighting & fan installation</li><li>Power outlet repairs</li><li>Safety testing</li></ul>',
    'image' => 'electrician.webp',
  ],
  'medical-shop' => [
    'title' => 'Medical Shop',
    'short' => 'Pharmacy and over-the-counter essentials near you.',
    'description' => '<p>Local medical shops / pharmacies providing medicines, first aid, and health advice.</p><ul><li>Prescription fulfilment</li><li>OTC medicines and medical supplies</li></ul>',
    'image' => 'medical-shop.jpg',
  ],
  'grocery-shop' => [
    'title' => 'Grocery Shop',
    'short' => 'Groceries and essentials delivered or picked up.',
    'description' => '<p>Small grocery stores and delivery helpers that keep your pantry stocked.</p><ul><li>Fresh produce</li><li>Staples & packaged goods</li><li>Delivery on request</li></ul>',
    'image' => 'grocery-shop.jpg',
  ],
  'home-repair' => [
    'title' => 'Home Repair',
    'short' => 'Carpentry, painting and general maintenance.',
    'description' => '<p>Handymen and repair services for household maintenance tasks.</p>',
    'image' => 'home-repair.jpg',
  ],
  'laundry' => [
    'title' => 'Laundry & Dry Clean',
    'short' => 'Wash, fold and dry-clean services.',
    'description' => '<p>Local laundry shops offering pickup and drop-off services.</p>',
    'image' => 'laundry.jpeg',
  ],
  'tutor' => [
    'title' => 'Tutor / Lessons',
    'short' => 'Local tutors for academic and skill-building classes.',
    'description' => '<p>Find tutors for children and adults in common school subjects and extra-curricular skills.</p>',
    'image' => 'tutor.jpg',
  ],
 'auto-garage' => [
  'title' => 'Auto Garage / Car Service',
  'short' => 'Car repair, servicing, and maintenance by local garages.',
  'description' => '
    <p>Professional auto garages offering reliable vehicle repair and maintenance services.</p>
    <ul>
      <li>General car servicing</li>
      <li>Engine diagnostics</li>
      <li>Brake and clutch repair</li>
      <li>Oil change and tune-up</li>
      <li>Battery replacement</li>
    </ul>
  ',
  'image' => 'auto-garage.png',
],

];

?>