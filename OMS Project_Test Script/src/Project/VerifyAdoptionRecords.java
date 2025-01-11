package Project;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;
import java.util.List;

public class VerifyAdoptionRecords {
    public static void main(String[] args) {
        // Set up ChromeDriver
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Navigate to the login page
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            // Perform login
            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com");

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123");

            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            submitButton.click();

            // Verify redirection after login
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));

            // Navigate to the manage adoptions page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/manage_adoptions.php");

            // Wait for the page to load
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));

            // Verify the presence of "Existing Adoption Records" section
            verifyAdoptionRecordsSection(driver, "Existing Adoption Records");

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
        } finally {
            driver.quit();
        }
    }

    private static void verifyAdoptionRecordsSection(WebDriver driver, String sectionName) {
        try {
            // Locate the text "Existing Adoption Records" on the page
            List<WebElement> adoptionRecordsElements = driver.findElements(By.xpath("//*[contains(text(), '" + sectionName + "')]"));

            if (!adoptionRecordsElements.isEmpty()) {
                System.out.println(sectionName + ": Found ✅");
            } else {
                System.out.println(sectionName + ": Not Found ❌");
            }
        } catch (Exception e) {
            System.out.println("An error occurred while verifying " + sectionName + ": " + e.getMessage());
        }
    }
}
