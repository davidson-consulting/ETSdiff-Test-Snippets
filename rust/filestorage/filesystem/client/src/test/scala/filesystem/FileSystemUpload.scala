package filesystem

import io.gatling.core.Predef._
import io.gatling.http.Predef._

import java.util.concurrent.ThreadLocalRandom

import scala.util.Random
import scala.util.matching._

import java.io._

import scala.collection.mutable.HashMap


/**
  * Uploading file scenario
  * It assumes the scenario IsUp was already launched once
  */
class FileSystemUpload extends Simulation {

  var savedIds : Array [Map[String, String]] = Array ()
  val feeder = initGlobals ()

  /**
    *  ==================================================================================
    *  ==================================================================================
    *  =======================             GLOBALS               ========================
    *  ==================================================================================
    *  ==================================================================================
    */

  def initGlobals () = {
    val f = csv ("files.csv")
    f.circular
  }

  /**
    *  ==================================================================================
    *  ==================================================================================
    *  =======================               TASKS                =======================
    *  ==================================================================================
    *  ==================================================================================
    */

  def uploadFile () = {
    feed (feeder)
      .exec (
        http ("UploadFile")
          .post ("/files")
          .header ("Content-type", "multipart/form-data")
          .bodyPart (RawFileBodyPart ("file", "#{path}"))
          .check (
            bodyString.saveAs ("id")
          )
      )
      .exec { session =>
        val fw = new FileWriter ("src/test/resources/ids.csv", true);
        try {
          val id = session ("id").as[String]
          val path = session ("path").as[String]
          fw.write (path);
          fw.write (",")
          fw.write (id);
          fw.write ("\n");
        }
        finally fw.close ();
        session
      }
  }

  /**
    *  ==================================================================================
    *  ==================================================================================
    *  =======================               MAIN                ========================
    *  ==================================================================================
    *  ==================================================================================
    */

  val httpProtocol =
    http.baseUrl("http://192.168.1.17:8080")
      .acceptHeader("text/html,application/xhtml+xml,application/xml, application/json;q=0.9,*/*;q=0.8")
      .acceptLanguageHeader("en-US,en;q=0.5")
      .acceptEncodingHeader("gzip, deflate")
      .userAgentHeader(
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:16.0) Gecko/20100101 Firefox/16.0"
      );


  val uploadScenario = scenario ("upload").exec (uploadFile ())

  setUp (
    uploadScenario.inject (atOnceUsers (1))
  ).protocols (httpProtocol);

}
