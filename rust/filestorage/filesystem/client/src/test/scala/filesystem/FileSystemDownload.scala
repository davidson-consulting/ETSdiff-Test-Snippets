package filesystem

import io.gatling.core.Predef._
import io.gatling.http.Predef._

import java.util.concurrent.ThreadLocalRandom

import scala.util.Random
import scala.util.matching._

import java.io._

import scala.collection.mutable.HashMap


/**
  * Downloading file scenario
  * It assumes the scenario Upload was already launched once
  */
class FileSystemDownload extends Simulation {

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
    val f = csv ("ids.csv")
    f.circular
  }


  /**
    *  ==================================================================================
    *  ==================================================================================
    *  =======================               TASKS                =======================
    *  ==================================================================================
    *  ==================================================================================
    */

  def downloadFile () = {
    feed (feeder)
      .exec (
        http ("DonwloadFile")
          .get ("/files/#{id}")
          .check (
            status.is (200)
          )
      )
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

  val downloadScenario = scenario ("download").exec (downloadFile ());

  setUp (
    downloadScenario.inject (atOnceUsers (1))
  ).protocols (httpProtocol);

}
