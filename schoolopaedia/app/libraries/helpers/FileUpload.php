<?php

/**
 * Description of FileUpload
 * This file can be used to upload any type of file.
 * @author Sumit Singh
 */
class FileUpload {

    const EXTENSION_NOT_FOUND = 0002;
    const FILE_NOT_VALID = 0003;
    const FILE_LARGE_SIZE = 0004;
    const FILE_ALREADY_EXISTS = 0004;
    
    public static function postPicUpload() {

        $file = Input::file('fileToUpload');
        $allowed_Extensions = array('png', 'jpg', 'jpeg', 'sql');
        $new_Path = "test";
        $uploaded = self::uploadAnyFile($file, $new_Path, $allowed_Extensions, NULL, "hello");
        
        if (!$uploaded) {
            echo "File Not uploaded";
        } else {
            echo "uploaded";
        }
    }

    public static function uploadAnyFile($file, $new_Path, $allowed_Extensions = null, $allowed_Size = null, $new_Name = null){
    //public function uploadAnyFile($file, $new_Path) {

        $file_name = $file->getFilename();            // emporary file name
        $file_OriginalName = $file->getClientOriginalName();  // Original Name of the file
        $file_Size = $file->getClientSize();          // Size of the file
        $file_MimeType = $file->getClientMimeType();      // Mime Type of the file
        $file_Extension = $file->guessClientExtension();   // Ext of the file
        $file_TemporaryPath = $file->getRealPath();            // Temporary file path
        
       if($allowed_Extensions && in_array($file_Extension, $allowed_Extensions)){
           echo "NOt allowed Extension \n";
           return FALSE;
       }

        if (!$file->isValid()) {
            echo "NOt allowed file";
        }
       
       if($allowed_Size && $file_Size > $allowed_Size){
           echo "NOt allowed size";
           return FALSE;
       }
//       if(file_exists($file_name)){
//           echo "NOt allowed ";
//       }
//       
       if($new_Name){
        $uploaded = $file->move($new_Path, $new_Name.".".$file_Extension);           
       }else{
        $uploaded = $file->move($new_Path, $file_name);   
       }

        if ($uploaded) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
