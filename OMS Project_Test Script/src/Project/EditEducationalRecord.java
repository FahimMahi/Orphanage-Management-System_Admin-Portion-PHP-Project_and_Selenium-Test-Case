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

public class EditEducationalRecord {
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

            // Step 2: Navigate to the Educational Management page with edit record ID
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/educational_management.php?edit_record_id=2");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Educational Management Edit Page: Passed");

            // Step 3: Edit the Educational Record form
            WebElement schoolNameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("school_name")));
            schoolNameField.clear();
            schoolNameField.sendKeys("Milestone School");

            WebElement gradeField = driver.findElement(By.id("grade"));
            gradeField.clear();
            gradeField.sendKeys("A");

            WebElement performanceField = driver.findElement(By.id("performance"));
            performanceField.clear();
            performanceField.sendKeys("Improved performance with additional focus on sports.");

            WebElement extracurricularField = driver.findElement(By.id("extracurricular_activities"));
            extracurricularField.clear();
            extracurricularField.sendKeys("Basketball, Chess");

            WebElement attendanceField = driver.findElement(By.id("attendance"));
            attendanceField.clear();
            attendanceField.sendKeys("98% attendance");

            WebElement classField = driver.findElement(By.id("class"));
            classField.clear();
            classField.sendKeys("10th Grade - Updated");

            // Step 4: Scroll to and Click the Submit Button
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Edit Educational Record']"));
            ((JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", submitButton);
            ((JavascriptExecutor) driver).executeScript("arguments[0].click();", submitButton);

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert to proceed

            // Step 6: Verify the updated educational record in the table
            WebElement recordTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = recordTable.getText();

            if (tableContent.contains("Milestone School") &&
                tableContent.contains("A") &&
                tableContent.contains("Improved performance with additional focus on sports.") &&
                tableContent.contains("Basketball, Chess") &&
                tableContent.contains("98% attendance") &&
                tableContent.contains("10th Grade - Updated")) {
                System.out.println("Edit Educational Record Test: Passed - Educational record successfully updated.");
            } else {
                System.out.println("Edit Educational Record Test: Failed - Updated educational record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
