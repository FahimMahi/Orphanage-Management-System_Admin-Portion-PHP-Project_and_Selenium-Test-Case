package Emnei;

import org.openqa.selenium.By;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;

public class Mahi {
	 public static void main(String[] args) throws InterruptedException {
		 System.setProperty("webdriver.chrome.driver","C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
		 ChromeOptions options = new ChromeOptions();
		 options.addArguments("--remote-allow-origins=*");
		 ChromeDriver driver = new ChromeDriver(options);
		 driver.get("http://edgesqtautomation.wuaze.com/index.php");
		 Thread.sleep(1000);
		 driver.findElement(By.name("uname")).sendKeys("saikat");
		 driver.findElement(By.name("password")).sendKeys("1212");
		 driver.findElement(By.name("submit")).click();
		 String a = driver.getCurrentUrl();
		 String d = "http://edgesqtautomation.wuaze.com/list.php";
		 if(a.equals(d)) {
			 System.out.println("Passed");
		 }
		 else {
			 System.out.println("Failed");
		 }
	 }
}
