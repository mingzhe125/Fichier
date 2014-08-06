var xhr, hUploadSpeed;
function sendFile()
{
  document.getElementById("serverresponse").innerHTML = "";//clear previous server response

  var url = "upload.php";
  var formData = new FormData(document.getElementById("form1"));
  xhr = new XMLHttpRequest();

  xhr.upload.addEventListener('progress', uploadProgress, false);//EventListener for upload progress
  xhr.addEventListener('abort', uploadAbort, false);//EventListener for abort
  xhr.addEventListener('error', uploadError, false);//EventListener for error
  xhr.addEventListener('load', uploadThrough, false);//EventListener for completed upload

  xhr.open("POST", url, true);
  //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //no longer necessary here
  xhr.onreadystatechange = function()
  {
    if (xhr.readyState == 4 && xhr.status == 200)
    {
      document.getElementById("serverresponse").innerHTML = xhr.responseText;
    }
  }

  xhr.send(formData); //Send to server
  hUploadSpeed = setInterval(UploadSpeed, 1000); //per seconds
}

/*From here down is same for all the methods, notifications, and other eventListeners*/
var i = new TimeStructure();//creating a TimeStructure object
var j = new SizeStructure();//creating a SizeStructure object

function abort()
{
  clearInterval(hUploadSpeed);
  xhr.abort();
}

var uploaded = 0, prevUpload = 0, speed = 0, total = 0, remainingBytes = 0, timeRemaining = 0;
function uploadProgress(e)
{
  if (e.lengthComputable)
  {
    uploaded = e.loaded;
    total = e.total;
    //percentage
    var percentage = Math.round((e.loaded / e.total) * 100);
    document.getElementById('progress_percentage').innerHTML = percentage + '%';
    document.getElementById('progress').style.width = percentage + '%';

    document.getElementById("remainingbyte").innerHTML = j.BytesToStructuredString(e.total - e.loaded);//remaining bytes
    document.getElementById('uploadedbyte').innerHTML = j.BytesToStructuredString(e.loaded);//uploaded bytes
    document.getElementById('totalbyte').innerHTML = j.BytesToStructuredString(e.total);//total bytes
  }
}

function uploadAbort()
{
  document.getElementById('progress_percentage').innerHTML = '0%';
  document.getElementById('progress').style.width = '0px';
  document.getElementById("serverresponse").innerHTML = "Upload canceled";
  xhr = null;
}

function uploadError()
{
  document.getElementById('progress_percentage').innerHTML = '0%';
  document.getElementById('progress').style.width = '0px';
  document.getElementById("serverresponse").innerHTML = "An error occured.";
  clearInterval(hUploadSpeed);
  xhr = null;
}

function uploadThrough()
{
  document.getElementById('progress_percentage').innerHTML = 'Upload completed!';
  UploadSpeed();//flush
  clearInterval(hUploadSpeed);
  xhr = null;
}

function UploadSpeed()
{
  //speed
  speed = uploaded - prevUpload;
  prevUpload = uploaded;
  document.getElementById("speed").innerHTML = j.SpeedToStructuredString(speed);
  //Calculating ETR
  remainingBytes = total - uploaded;
  timeRemaining = remainingBytes / speed;
  document.getElementById("ETR").innerHTML = i.SecondsToStructuredString(timeRemaining);
}