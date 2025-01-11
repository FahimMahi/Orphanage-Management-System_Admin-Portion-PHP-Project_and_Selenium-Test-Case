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

public class AddAdoptionRecord {
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

            // Step 2: Navigate to the Manage Adoptions page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/manage_adoptions.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Manage Adoptions Page: Passed");

            // Step 3: Fill out the Add Adoption Record form
            WebElement childDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("child_id")));
            Select childSelect = new Select(childDropdown);
            childSelect.selectByVisibleText("Lionel Messi"); // Replace with the actual child's name

            WebElement adopterNameField = driver.findElement(By.id("adopter_name"));
            adopterNameField.sendKeys("Tanzim Sakib");

            WebElement adopterContactField = driver.findElement(By.id("adopter_contact"));
            adopterContactField.sendKeys("01714145241");

            WebElement adopterNidField = driver.findElement(By.id("adopter_nid"));
            adopterNidField.sendKeys("1234567890");

            WebElement adoptionDateField = driver.findElement(By.id("adoption_date"));
            adoptionDateField.sendKeys("31-12-2024");

            // Step 4: Submit the form
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Add Adoption Record']"));
            submitButton.click();

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert

            // Step 6: Verify the added adoption record in the table
            WebElement recordTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = recordTable.getText();

            // Debugging: Print table content for verification
            System.out.println("Table Content: " + tableContent);

            // Verify the added record is present in the table
            if (tableContent.contains("Lionel Messi") &&
                tableContent.contains("Tanzim Sakib") &&
                tableContent.contains("01714145241") &&
                tableContent.contains("1234567890") &&
                tableContent.contains("2024-12-31")) {
                System.out.println("Add Adoption Record Test: Passed - Record successfully added.");
            } else {
                System.out.println("Add Adoption Record Test: Failed - Record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
