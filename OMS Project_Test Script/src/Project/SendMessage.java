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

public class SendMessage {
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

            // Step 2: Navigate to the Messages page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/messages.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Messages Page: Passed");

            // Step 3: Fill out the Send Message form
            WebElement receiverDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("receiver_id")));
            Select receiverSelect = new Select(receiverDropdown);
            receiverSelect.selectByVisibleText("Mim"); // receiver_username

            WebElement messageTextArea = driver.findElement(By.id("message_text"));
            messageTextArea.sendKeys("HEY! What's Up?");

            // Step 4: Submit the form
            WebElement sendButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Send Message']"));
            sendButton.click();

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert

//            // Step 6: Verify the sent message in the Inbox table
//            WebElement inboxTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
//            String tableContent = inboxTable.getText();
//
//            // Debugging: Print table content for verification
//            System.out.println("Inbox Table Content: " + tableContent);
//
//            // Verify the sent message is present in the table
//            if (tableContent.contains("This is a test message.") && tableContent.contains("mahi")) { // Replace 'mahi' with the sender's username
//                System.out.println("Send Message Test: Passed - Message successfully sent and displayed in Inbox.");
//            } else {
//                System.out.println("Send Message Test: Failed - Message not found in Inbox.");
//            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
