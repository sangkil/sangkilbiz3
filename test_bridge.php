 <?php require_once("java/Java.inc");

/**
 * This example demonstrates how to use a complex library such as
 * Eclipse BIRT. This library starts a number of threads, which must
 * be terminated before the library is unloaded. This is usually done
 * in the servlet's destroy() method or in the destroy() method of
 * an associated ServletContextListener.
 * 
 * To allow startup and shutdown of such libraries, the PHP/Java
 * Bridge provides two convenience procedures, which allow one to run
 * a synchronized init() and to register a close() hook with the
 * servlet or the VM. Please see the API documentation of
 * java_context()->init() and java_context()->onShutdown() for
 * details.
 * 
 * To use this sample, copy "report.php", "test.rptdesign" (and
 * "Java.inc", if needed) to some directory, start the Java back- end
 * (tomcat, or any other J2EE server) and type:
 *
 * php report.php >helloBirt.html
 *
 */

// the report file to render
$myReport = "test.rptdesign";

// the output format
$myFormat = "html";


// load resources from the current working dir
$here = getcwd();

$ctx = java_context()->getServletContext();
$birtReportEngine =        java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());

function getOutputFormat($format) {
  $fmt = null;

  switch($format) {
  case "pdf": 
    $fmt = new java("org.eclipse.birt.report.engine.api.PDFRenderOption");
    $fmt->setOutputFormat("pdf");
    header("Content-type: application/pdf");
    break;
  case "html": 
    $fmt = new java("org.eclipse.birt.report.engine.api.HTMLRenderOption");
    $fmt->setOutputFormat("html");
    $ih = new java( "org.eclipse.birt.report.engine.api.HTMLServerImageHandler");
    $fmt->setImageHandler($ih);
    header("Content-type: text/html");
    break;
  case "msword":
    $fmt = new java("org.eclipse.birt.report.engine.api.RenderOption");
    $fmt->setOutputFormat("doc");
    header("Content-type: application/msword");
    break;
  case "xls":
    $fmt = new java("org.eclipse.birt.report.engine.api.RenderOption");
    $fmt->setOutputFormat("xls");
    header("Content-type: application/vnd.ms-excel");
    break;
  default: die("unknown output format $format");
  }

  return $fmt;
}
    

try {

  $engine = $birtReportEngine->openReportDesign("${here}/${myReport}");
  $task = $birtReportEngine->createRunAndRenderTask($engine);
  $fmt = getOutputFormat($myFormat);
  $fmt->setOutputStream($out=new java("java.io.ByteArrayOutputStream"));
  
  $task->setRenderOption($fmt);
  $task->run();
  $task->close();

} catch (JavaException $e) {
  echo $e;
}

echo java_values($out->toByteArray());

?>
