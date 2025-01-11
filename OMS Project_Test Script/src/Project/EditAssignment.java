package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class EditAssignment {
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

            // Step 2: Navigate to the Staff Child Management page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/staff_child_management.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Staff Child Management Page: Passed");

            // Step 3: Open the edit form for the specific assignment (assignment_id=4)
            WebElement editButton = wait.until(ExpectedConditions.visibilityOfElementLocated(
                    By.xpath("//tr[td[contains(text(), '4')]]//button[@class='edit-button']")));
            editButton.click();

            // Step 4: Update the child and staff in the edit form
            WebElement childDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("edit-child-id")));
            Select childSelect = new Select(childDropdown);
            childSelect.selectByVisibleText("Cristiano Ronaldo"); // Replace with updated child's name

            WebElement staffDropdown = driver.findElement(By.id("edit-staff-id"));
            Select staffSelect = new Select(staffDropdown);
            staffSelect.selectByVisibleText("Fahim Mahi"); // Replace with updated staff's name

            WebElement updateButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Update Assignment']"));

            // Scroll to the Update button to ensure it is visible
            ((org.openqa.selenium.JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", updateButton);

            // Click the button after scrolling
            updateButton.click();

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept();

            // Step 6: Verify the updated assignment in the table
            WebElement assignmentsTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = assignmentsTable.getText();

            if (tableContent.contains("Cristiano Ronaldo") && tableContent.contains("Fahim Mahi")) {
                System.out.println("Edit Assignment Test: Passed - Assignment successfully updated.");
            } else {
                System.out.println("Edit Assignment Test: Failed - Updated assignment not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
