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
import java.util.List;

public class DeleteUser {
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

            // Step 4: Navigate to Manage Users Page
            WebElement manageUsersLink = wait.until(ExpectedConditions.visibilityOfElementLocated(By.linkText("Manage Users")));
            manageUsersLink.click();

            String expectedManageUsersUrl = "http://localhost:8080/Orphanage-Management-System/Views/manage_users.php";
            wait.until(ExpectedConditions.urlToBe(expectedManageUsersUrl));
            System.out.println("Navigation to Manage Users: Passed");

            // Step 5: Delete User by ID
            // Locate the delete button using the unique ID
            WebElement deleteButton = wait.until(ExpectedConditions.visibilityOfElementLocated(
                By.xpath("//tr[td[contains(text(), '10')]]//input[@value='Delete']"))); 
            deleteButton.click();

            // Step 6: Handle Alert (confirmation dialog)
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Confirm deletion

            // Step 7: Verify Deletion in the Table
            // Wait for the table to refresh or dynamically update
            Thread.sleep(2000); // Add a short wait for AJAX/dynamic updates if necessary
            WebElement userTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));

            // Check if the user with ID 10 is still present in the table
            List<WebElement> rows = userTable.findElements(By.xpath("//tr[td[contains(text(), '10')]]"));
            if (rows.isEmpty()) {
                System.out.println("Delete User Test: Passed - User with ID 10 is no longer present.");
            } else {
                System.out.println("Delete User Test: Failed - User with ID 10 is still present.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace(); // Print stack trace for debugging
        } finally {
            driver.quit();
        }
    }
}
