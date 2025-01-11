package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class AddEducationalRecord {
    public static void main(String[] args) {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Step 1: Login to the system
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com"); 

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123"); 

            WebElement loginButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            loginButton.click();

            // Verify login and navigate to the dashboard
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));
            System.out.println("Login Test: Passed");

            // Step 2: Navigate to the Educational Management page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/educational_management.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Educational Management Page: Passed");

            // Step 3: Fill out the "Add Educational Record" form
            WebElement childDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("child_id")));
            Select childSelect = new Select(childDropdown);
            childSelect.selectByValue("8"); // Replace with valid child ID for Lionel Messi

            WebElement schoolNameField = driver.findElement(By.id("school_name"));
            schoolNameField.sendKeys("Barcelona International School");

            WebElement gradeField = driver.findElement(By.id("grade"));
            gradeField.sendKeys("A+");

            WebElement performanceField = driver.findElement(By.id("performance"));
            performanceField.sendKeys("Excellent performance in academics and sports.");

            WebElement extracurricularField = driver.findElement(By.id("extracurricular_activities"));
            extracurricularField.sendKeys("Football, Basketball");

            WebElement attendanceField = driver.findElement(By.id("attendance"));
            attendanceField.sendKeys("95% attendance this year");

            WebElement classField = driver.findElement(By.id("class"));
            classField.sendKeys("10th Grade");

            // Step 4: Scroll and Click the Submit Button
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Add Educational Record']"));
            ((JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", submitButton); // Scroll into view
            ((JavascriptExecutor) driver).executeScript("arguments[0].click();", submitButton); // Use JS to click the button

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert to proceed

            // Step 6: Verify the new educational record in the table
            WebElement recordTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = recordTable.getText();

            if (tableContent.contains("Barcelona International School") &&
                tableContent.contains("A+") &&
                tableContent.contains("Excellent performance in academics and sports.") &&
                tableContent.contains("Football, Basketball") &&
                tableContent.contains("95% attendance this year") &&
                tableContent.contains("10th Grade")) {
                System.out.println("Add Educational Record Test: Passed - Educational record successfully added to the table.");
            } else {
                System.out.println("Add Educational Record Test: Failed - Educational record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
