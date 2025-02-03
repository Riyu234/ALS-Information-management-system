<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
$learner_id = $_GET['id'];
$sqll = $conn->prepare("SELECT * FROM learner where learner_id = :id");
$sqll->bindParam(':id', $learner_id);
$sqll->execute();
$students = $sqll->fetch(PDO::FETCH_ASSOC);

$firstname = $students['firstname'];
$lastname = $students['lastname'];
$middlename = $students['middlename'];

require '../../../php/vendor/autoload.php'; // Adjust the path to your autoload file

use PhpOffice\PhpWord\PhpWord;

// Create a new PhpWord object
$phpWord = new PhpWord();

// Add a section with A4 paper size in portrait orientation
$section = $phpWord->addSection([
    'orientation' => 'portrait',
    'paperSize' => 'A4',
]);

// Add a table to align the header content (logos and school details)
$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);
$table->addRow();

// Add the left logo
$table->addCell(1000)->addImage('../assets/img/deped-logo.png', [
    'width' => 70,
    'height' => 70,
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
]);

// Add the header text in the center cell
$cell = $table->addCell(6000);

// Center-align text explicitly
$cell->addText("Department of Education", [
    'name' => 'Arial',
    'size' => 12,
    'bold' => true,
], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

$cell->addText("ALTERNATIVE LEARNING SYSTEM", [
    'name' => 'Arial',
    'size' => 14,
    'bold' => true,
], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

$cell->addText("Municipality Of BInalbagan", [
    'name' => 'Arial',
    'size' => 12,
    'bold' => true,
], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

$cell->addText("La Filipina National High School Learning Center", [
    'name' => 'Arial',
    'size' => 10,
], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

// Add the right logo
$table->addCell(1000)->addImage('../assets/img/orig-logo.png', [
    'width' => 70,
    'height' => 70,
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
]);

$section->addTextBreak(4); // Line break

// Add the date
$section->addText("June 25, 2016", [
    'name' => 'Arial',
    'size' => 12,
    'alignment' => 'left',
]);

$section->addTextBreak(2); // Line break

// Add "To Whom It May Concern" heading
$section->addText("To Whom It May Concern;", [
    'name' => 'Arial',
    'size' => 12,
]);

$section->addTextBreak(1); // Line break

// Add the body text with placeholders
$textRun = $section->addTextRun();

$textRun->addText("This is to certify that ", [
    'name' => 'Arial',
    'size' => 12,
]);

// Add the bold and underlined part
// Add the bold and underlined part dynamically
// Add the bold, underlined, and uppercase part dynamically
$textRun->addText(strtoupper($firstname . " " . $middlename . " " . $lastname), [
    'name' => 'Arial',
    'size' => 12,
    'bold' => true,
    'underline' => true,
]);


// Add the remaining normal text
$textRun->addText(" is enrolled to the Alternative Learning System of the Binalbagan National High School Learning Center, Binalbagan, Municipality, for the School Year 2016-2017.", [
    'name' => 'Arial',
    'size' => 12,
]);

$section->addTextBreak(2); // Line break

// Add the purpose text
$section->addText("This certification is issued for 4Ps APPLICATION and ROOF OF ENROLMENT.", [
    'name' => 'Arial',
    'size' => 12,
]);

$section->addTextBreak(2); // Line break

// Add the footer with signature line
$section->addText("Signed:", [
    'name' => 'Arial',
    'size' => 12,
]);
$section->addTextBreak(4);
$section->addText("__________________________", [
    'name' => 'Arial',
    'size' => 12,
    'bold' => true,
    'underline' => true,
    'alignment' => 'center',
]);
$section->addText("MR. EUGENE S. ABULOC", [
    'name' => 'Arial',
    'size' => 12,
    'bold' => true,
    'alignment' => 'center',
]);
$section->addText("School ALS Coordinator", [
    'name' => 'Arial',
    'size' => 12,
    'alignment' => 'center',
]);

// Save the document as a .docx file
$fileName = 'certificate_of_enrollment2.docx'; 
$phpWord->save($fileName, 'Word2007');

// Force the file to download
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Length: " . filesize($fileName));
readfile($fileName);
exit();
header("location:studentcoe.php");
?>
