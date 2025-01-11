package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class EditUserTest {
    public static void main(String[] args) {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Step 1: Navigate to Login Page
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            // Step 2: Perform Login
            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com");

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123");

            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            submitButton.click();

            // Step 3: Verify Login and Navigate to Dashboard
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));
            System.out.println("Login Test: Passed");

            // Step 4: Navigate to the Edit User Page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/manage_users.php?edit_user_id=7");

            // Step 5: Edit User Details
            WebElement usernameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("username")));
            usernameField.clear(); // Clear the existing username
            usernameField.sendKeys("Fahim Mahi"); // Enter new username

            WebElement emailInput = driver.findElement(By.id("email"));
            emailInput.clear(); // Clear the existing email
            emailInput.sendKeys("mahiiiiiiii@gmail.com"); // Enter new email

            WebElement roleSelect = driver.findElement(By.id("role"));
            roleSelect.sendKeys("Medical"); // Update role

            // Step 6: Save Changes
            WebElement saveButton = driver.findElement(By.name("edit_user")); // Locate the save button
            saveButton.click();

            // Step 7: Handle Alert After Saving
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Click "OK" on the alert

            // Step 8: Verify the Changes in the Table
            WebElement userTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = userTable.getText();

            if (tableContent.contains("Fahim Mahi") &&
                tableContent.contains("mahiiiiiiii@gmail.com") &&
                tableContent.contains("Medical")) {
                System.out.println("Edit User Test: Passed");
            } else {
                System.out.println("Edit User Test: Failed");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
        } finally {
            driver.quit();
        }
    }
}
