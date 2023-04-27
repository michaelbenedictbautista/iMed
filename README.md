# iMed

A health management system is a system that is designed to manage and coordinate healthcare service delivery. It can be used by medical health providers, such as hospitals and clinics, as well as by individuals to manage their own medical infrastructure.

The website application involves CRUD functionality that allows you to create, read, update, and delete data in our database. Here's a step-by-step guide to using our website:

1. Creating a new record:
   To create a new record in our database, click on the "Create" button available in Side menu panel(available only in developer user level 1). You will be redirected to a new page where you can fill in the required information for the new record. Once you have filled in all the necessary information, click on the "Add" button to create the new record.
2. Reading existing records:
   To view existing records in our database, click on the "View" button available in Side menu panel(available only in developer user level 1). A new modal will pop up that will displays all the records currently in the database.
   In addition, there is a search function, you can use the search bar to type the patient's name and filter the records based on selected specific criteria in status' dropdown list.
3. Updating an existing record:
   To update an existing record in our database, click on the "Edit" button available in Side menu panel(available only in developer user level 1). You will be redirected to a new page where you can edit the information for the record. Once you have made the necessary changes, click on the "Save" button to update the record.
4. Deleting an existing record:
   To delete an existing record from our database, click on the "Delete" available in Side menu panel(available only in developer user level 1). A confirmation dialog will appear asking you to confirm that you want to delete the record. Click on the "Yes" button to delete the record.

Steps in downloading and operating the iMed application:

1. Download, install and open Docker after installation. Please refer to this [link](https://www.docker.com/products/docker-desktop) in order to download docker application.
2. Download the zip file under "Dev" branch and or git clone to your own device, make sure you are in the right branch.
3. After downloading, unzip the folder to your designated folder and open it to your preferred text/code editor.
4. Open the terminal and change directory to www folder by typing "cd www" to your terminal.
5. Once, you are in the same level with Dockerfile, type the following command "docker compose up" to create a Docker container.
6. Go back to your Docker, and you will see the new container "iMed".
7. Hit the start icon opposite to iMed to run the container and other dependencies for the project.
8. Click the link for the localhost:8080 to open the webpage.
9. Start manipulating the web app by signing in.
10. Explore different CRUD functions and the Optical Character recognition.

## Cropper.js

Cropper.js is a JavaScript library that allows you to crop images in the browser. Here's a step-by-step guide to using Cropper.js

1. Getting Started:
   Cropper.js dependencies and library was already included this application. All we will need is to create a new instance of the Cropper object later.
2. Loading an image:
   Select an image from your computer to be cropped. Once the image is loaded, a Cropper object will be initialised by the appplication automatically.
3. Cropping an image:
   To crop an image using Cropper.js, you can use the mouse to select the area of the image you want to crop. Once you have selected the area, you can click on the "Crop" button to crop the image. The cropped image will be displayed in the preview area.
4. Adjusting the crop:
   You can adjust the crop by using the mouse to drag the corners or sides of the crop area. You can also use the arrow keys on your keyboard to move the crop area.
5. Saving the cropped image:
   After cropping the image you can either save the image or run the Tesseract Optical Character Recognition application. Further details will be discussed below regarding OCR app.
6. Documentation:
   For further documentation reference, kindly follow to this [link](https://github.com/fengyuanchen/cropperjs#events).

## Tesseract Optical Character Recognition application

Tesseract OCR is an open-source optical character recognition engine that allows you to extract text from images. Here's a step-by-step guide to using Tesseract OCR with the cropped image:

1. Getting Started:
   Tesseract OCR application, dependencies and library(https://packagist.org/packages/thiagoalessio/tesseract_ocr) was already included this application as well.
2. Exporting the cropped image:
   Once you have cropped the image, you can use Tesseract OCR to extract text from the image by clicking the "extract" button in the option.
3. OCR process:
   Once you click the button, Tesseract OCR will analyse the image and output the extracted text to the specified preview area.
4. Saving the extracted text:
   Once done, you can click the save to save the extracted text together with the cropped image.
5. Documentation:
   For further documentation reference, kindly follow to this [link](https://packagist.org/packages/thiagoalessio/tesseract_ocr).