# laravel-image-gallery

---

This bundle has code to create simple image galleries in Laravel 5.1 or higher on Ubuntu 14.04. It allows you to upload images and stores the original image along with three other sizes - thumb, medium and large. It stores all of the image information in the database along with things like title, caption, description, alt tag, etc.

The code here assumes the images will be attached to a model named Gallery, but you can attach it to any model like Product or Company. You will just need to find-and-replace all instances of "gallery" with your model name. (Make sure you do a case-sensitive replace.)

This is built using Intervention Image, an open source PHP image handling and manipulation library. Included below are the basic steps for installing Image Intervention, but if you want more information visit there website at http://image.intervention.io/.

To use this bundle, install Intervention Image and copy the code from the included files, modifying them as you need.  

It might be nice to make a composer installable package for this but, for the time being, I do not have time to make one.