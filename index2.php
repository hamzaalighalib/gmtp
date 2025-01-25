<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghalib Mail || Mail by Ghalib | secure fastest</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <style>
        .hidden { display: none; }
        .active { font-weight: bold; }
        .transition { transition: transform 0.5s ease, opacity 0.5s ease; opacity: 1; }
        .slide-in { transform: translateY(100%); opacity: 0; }
        .slide-out { transform: translateY(-100%); opacity: 0; }
        .visible { transform: translateY(0); opacity: 1; }
        .back-arrow { font-size: 1.5rem; color: #4CAF50; cursor: pointer; margin-top: 10px; }
        .list-item { transition: all 0.3s ease; }
        .list-item:hover { background-color: #f9fafb; }
        .list-item:active { background-color: #e5e7eb; }

        /* For mobile responsive sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 240px;
                height: 100%;
                background-color: #ffffff;
                transition: left 0.3s ease;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar button {
                padding: 1rem;
            }

            .toggle-sidebar {
                display: block;
            }

            .sidebar-header {
                display: flex;
                justify-content: space-between;
                padding: 1rem;
                background-color: #ffffff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .main-content {
                margin-left: 0;
                transition: margin-left 0.3s ease;
            }

            .main-content.shifted {
                margin-left: 240px;
            }
        }

        /* Style the copy button */
.copy-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.copy-btn:hover {
    background-color: #0056b3;
}

/* Add some space around the email content */
.email-body {
    position: relative;
}

/* Style the code block */
pre.code-block {
    background-color: #f4f4f4;
    border: 1px solid #ccc;
    padding: 1em;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: monospace;
    overflow-x: auto;
}

code {
    font-size: 1.1em;
}


    </style>
</head>
<body class="bg-gray-100 text-gray-800">


 <!-- Notification Div -->
    <div id="notification" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white p-4 rounded-lg shadow-lg hidden">
        <div class="flex items-center">
            <div id="notification-message" class="mr-4">This is a notification message.</div>
            <div class="flex-1 relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gray-300 rounded-full">
                    <div id="progress-bar" class="h-1 bg-green-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

  <div class="sm:hidden sidebar-header flex items-center mb-6">
    <button class="toggle-sidebar text-xl" onclick="toggleSidebar()">☰</button> 
    <img src="https://scontent.xx.fbcdn.net/v/t1.15752-9/474026039_1701136564082392_8029143301287911518_n.png?_nc_cat=102&ccb=1-7&_nc_sid=0024fc&_nc_ohc=EVtkguoxS1sQ7kNvgFhs6lj&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=scontent.xx&oh=03_Q7cD1gHyHl5yGmaNHYTP2QLvH8mrhKKJxhPYWGSDyt3HYn10bg&oe=67B959CB" alt="Ghalib Mail Pro" class="h-12"/>
 </div>

    <div class="flex h-screen">
<?php

// Function to detect mobile devices based on the user agent
function isMobile() {
    return preg_match('/(iphone|ipod|ipad|android|windows phone|blackberry|mobile)/i', $_SERVER['HTTP_USER_AGENT']);
}

// Conditionally display the sidebar based on the device type
if (isMobile()) {
    echo '
        <!-- Sidebar for Mobile -->
        <div class="bg-white h-screen p-4 overflow-y-auto w-full " id="sidebarformobile">
            <h2 class="text-2xl font-bold mb-4">Ghalib Mail</h2>
            <nav class="w-full bg-white shadow-md p-4 space-y-4 main-content">
                <div class="flex items-center mb-6">
                    <img src="https://scontent.xx.fbcdn.net/v/t1.15752-9/474026039_1701136564082392_8029143301287911518_n.png?_nc_cat=102&ccb=1-7&_nc_sid=0024fc&_nc_ohc=EVtkguoxS1sQ7kNvgFhs6lj&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=scontent.xx&oh=03_Q7cD1gHyHl5yGmaNHYTP2QLvH8mrhKKJxhPYWGSDyt3HYn10bg&oe=67B959CB" alt="Ghalib Mail Pro" class="h-12"/>
                    <h3 class="text-xl font-bold text-gray-400">Mail</h3>
                </div>
                <div class="emailauth" id="emailauth"></div>
                <div class="space-y-2">
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="unread">Unread
                        <span id="unread-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                    </button>
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="inbox">Inbox
                        <span id="inbox-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                    </button>
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="spam">Spam
                        <span id="spam-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                    </button>
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg border-2" data-target="compose">Compose</button>
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="about">About</button>
                    <button  onclick="toggleSidebar()" class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="terms">Terms</button>
                </div>
            </nav>
        </div>';
} else {
    // Optionally, you can display something else if not mobile
    // For example, you can show a desktop version of the sidebar or something else
    echo ' <!-- Sidebar -->
        <nav class="sidebar w-64 bg-white shadow-md p-4 space-y-4 hidden sm:block">
            <div class="sidebar-header flex items-center mb-6">
                <img src="https://scontent.xx.fbcdn.net/v/t1.15752-9/474026039_1701136564082392_8029143301287911518_n.png?_nc_cat=102&ccb=1-7&_nc_sid=0024fc&_nc_ohc=EVtkguoxS1sQ7kNvgFhs6lj&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=scontent.xx&oh=03_Q7cD1gHyHl5yGmaNHYTP2QLvH8mrhKKJxhPYWGSDyt3HYn10bg&oe=67B959CB" alt="Ghalib Mail Pro" class="h-12"/>
                 <h3 class="text-xl font-bold text-gray-400">Mail</h3>
            </div>
            <div class="emailauth" id="emailauth"></div>
            <div class="space-y-2">
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="unread">Unread
                    <span id="unread-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                </button>
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="inbox">Inbox
                    <span id="inbox-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                </button>
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="spam">Spam
                    <span id="spam-count" class="bg-blue-600 float-right text-white py-1 px-3 m-1 rounded-full">0</span>
                </button>
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg border-2" data-target="compose">Compose</button>
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="about">About</button>
                <button class="w-full p-2 text-left text-blue-500 hover:text-gray-600 hover:bg-slate-100 rounded-lg" data-target="terms">Terms</button>
            </div>
        </nav>
';
}

?>

       
    

        <!-- Main Content -->
        <main id="app" class="flex-1 p-4 overflow-y-auto main-content">
            <!-- Inbox -->
            <section id="inbox" class="hidden  sm:block">
                <h2 class="text-2xl font-bold mb-4">Inbox</h2>
                <ul id="email-list" class="space-y-2">
                </ul>
            </section>

            <!-- Unread -->
            <section id="unread" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Unread</h2>
                <ul id="unread-list" class="space-y-2">
                    <!-- Unread emails will load here dynamically -->
                </ul>
            </section>

            <!-- Spam -->
            <section id="spam" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Spam</h2>
                <ul id="spam-list" class="space-y-2">
                    <!-- Spam emails will load here dynamically -->
                </ul>
            </section>

            <!-- Full Email -->
            <section id="full-mail" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Email</h2>
                <span class="back-arrow bg-slate-100 text-2xl hover:bgg-slate-100 cursor-pointer rounded-full p-4" onclick="navigateBack()"> ← </span>
                <div id="full-email-content">
                    <!-- Full email content will load here -->
                </div>
            </section>

            <!-- Compose Email -->
            <section id="compose" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Compose Email</h2>
                <form id="compose-form" class="space-y-4">
                    <div>
                        <label for="receiver" class="block text-sm font-medium">Receiver:</label>
                        <input type="email" id="receiver" name="receiver" class="border rounded w-full p-2" required />
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium">Subject:</label>
                        <input type="text" id="subject" name="subject" class="border rounded w-full p-2" required />
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-medium">Message:</label>
                        <textarea id="body" name="body" class="border rounded w-full p-2" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
                </form>
            </section>

            <!-- About Page -->
            <section id="about" class="hidden">
                <h2 class="text-2xl font-bold mb-4">About</h2>
                <p>This is GMPT (Ghalib Mail Transfer Protocol) which is built by Hamza Ali Ghalib and based on HTTP requests between any web server that uses this library. This is an alternative to SMTP, designed for secure and fast email communication.</p>
                <p>Developed by: Hamza Ali Ghalib, Full Stack Web Developer</p>
                <p>Special thanks to my friend Danial Azam, Senior Developer.</p>
            </section>

            <!-- Terms Page -->
            <section id="terms" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Terms and Conditions</h2>
                <p>Here are the terms and conditions for using Ghalib Mail Pro. (Write your terms and conditions here)</p>
            </section>
        </main>
    </div>

    <script>
        let senderemail = "ghalibuser@"+window.location.hostname; //set dinamcly in production mode : --- : 
        document.getElementById("emailauth").innerText = "Hi, "+ senderemail;
        let globalEmails = [];
        let unreadEmails = [];
        let spamEmails = [];

        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('nav button');
        const emailList = document.getElementById('email-list');
        const unreadList = document.getElementById('unread-list');
        const spamList = document.getElementById('spam-list');
        const fullEmailContent = document.getElementById('full-email-content');
        const mainContent = document.getElementById('app');
        const inboxCount = document.getElementById('inbox-count');
        const unreadCount = document.getElementById('unread-count');
        const spamCount = document.getElementById('spam-count');

        function navigate(target) {
            sections.forEach(section => section.classList.add('hidden'));
            sections.forEach(section => section.classList.add('sm:hidden'));
            const targetSection = document.getElementById(target);
            targetSection.classList.remove('hidden');
            targetSection.classList.remove('sm:hidden');

            mainContent.classList.add('transition');
            mainContent.classList.remove('slide-out');
            mainContent.classList.add('slide-in');

            setTimeout(() => {
                mainContent.classList.remove('slide-in');
            }, 500);

            history.pushState({ target }, '', `#${target}`);
        }

        navLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                navigate(e.target.dataset.target);
            });
        });

        window.addEventListener('popstate', e => {
            console.log(e.state.target)
            const target = e.state?.target || 'inbox';
            navigate(target);
        });

async function loadMailbox() {

      for (let i = 0; i < 5; i++) {
                const li = document.createElement('li');
                li.className = `p-4 h-20 rounded-lg shadow-md cursor-pointer overflow-hidden bg-white hover:bg-gray-100 flex items-center space-x-4 animate-pulse`;

                // Skeleton structure for the email
                li.innerHTML = `
                    <div class="flex-1 w-full">
                        <!-- Skeleton for Email Title -->
                        <div class="w-3/4 h-6 bg-gray-300 rounded-lg mb-2"></div>
                        <!-- Skeleton for Email Body -->
                        <div class="w-5/6 h-4 bg-gray-300 rounded-lg mb-2"></div>
                    </div>
                    <!-- Skeleton for Time -->
                    <div class="w-16 h-4 bg-gray-300 rounded-full"></div>
                `;

                // Append skeleton to the email list
                emailList.appendChild(li);
            }

    try {
        const response = await fetch('routes/get_email.php?get=all');
        const result = await response.json();
        console.log(result);

        if (!result.success) {
            throw new Error(result.error || 'Failed to load emails');
        }

        if (result.message === "No emails found") {
            // If no emails found, display an appropriate message
            emailList.innerHTML = '<li>No emails found</li>';
            inboxCount.innerText = 0;
            unreadCount.innerText = 0;
            spamCount.innerText = 0;
            return;
        }

        globalEmails = result.data || [];

        // Filter unread and spam emails
        unreadEmails = globalEmails.filter(email => email.status !== "read");
        spamEmails = globalEmails.filter(email => email.status === "spam");

        // Render the email lists
        renderEmailList(globalEmails);
        renderEmailListUnread(unreadEmails);
        renderEmailListSpam(spamEmails);

        // Update the count of emails
        inboxCount.innerText = globalEmails.length;
        unreadCount.innerText = unreadEmails.length;
        spamCount.innerText = spamEmails.length;

    } catch (error) {
        console.log(error);
        emailList.innerHTML = '<li>Error loading emails</li>';
    }
}


        function renderEmailList(emails) {
            emailList.innerHTML = ''; // Clear existing emails
            emails.forEach(email => {
                const li = document.createElement('li');
                li.className = `p-4 rounded-lg shadow-md cursor-pointer overflow-hidden bg-white hover:bg-gray-100 flex items-center space-x-4 ${email.status !== "read" ? 'border-l-4 border-blue-500' : ''}`;
                
                // Email structure
                li.innerHTML = `
                    <div class="flex-1 w-full">
                        <h4 class='text-lg font-medium ${email.status !== "read" ? 'font-semibold text-blue-600' : 'text-gray-800'}'>
                            ${email.sender} - ${email.subject}
                        </h4>
                        <span class="text-sm text-gray-600 overflow-hidden truncate">${email.body}</span>
                    </div>
                    <div class="text-xs text-gray-400">
                        ${email.timeAgo}
                    </div>
                `;

                // Marking the email as clicked to view
                li.addEventListener('click', () => viewEmail(email.id));

                // Append the email item to the list
                emailList.appendChild(li);
            });
        }

        function renderEmailListUnread(emails) {
                unreadList.innerHTML = '';
                emails.forEach(email => {
                    const li = document.createElement('li');
                    li.className = 'bg-white p-4 rounded shadow cursor-pointer hover:bg-gray-100';
                    li.innerHTML = `
                        <h3 class='font-bold'>${email.subject}</h3>
                        <p>${email.body}</p>`;
                    ;
                    li.addEventListener('click', () => viewEmail(email.id));
                    unreadList.appendChild(li);
                });
            }

        function renderEmailListSpam(emails) {
            spamList.innerHTML = 'empty spam emails';
            emails.forEach(email => {
                const li = document.createElement('li');
                li.className = 'bg-white p-4 rounded shadow cursor-pointer hover:bg-gray-100';
                li.innerHTML =` 
                    <h3 class='font-bold'>${email.subject}</h3>
                    <p>${email.body}</p>`;
                ;
                li.addEventListener('click', () => viewEmail(email.id));
                spamList.appendChild(li);
            });
        }


async function viewEmail(emailId) {
    try {
        const response = await fetch(`routes/get_email.php?get=one&id=${emailId}`);
        const result = await response.json();
        console.log(result)

        if (!result.success) {
            throw new Error(result.error || 'Failed to load email');
        }

        const email = result.data;

        // Format the time ago (if available), if not fallback to "Unknown time"
        const timeAgo = email.timeAgo || 'Unknown time';

        // Function to render markdown-like content (code blocks, preserved spaces)
        const renderMarkdown = (content) => {
            // Detect code blocks and attempt to identify language based on syntax
            content = content.replace(/```(.*?)```/gs, (match, code) => {
                // Automatically detect language based on syntax patterns
                const detectedLanguage = detectLanguage(code);

                return `
                    <div class="mx-2 code-block-container">
                        <pre class="code-block ${detectedLanguage}"><code>${sanitizeHtml(code)}</code></pre>
                        <button class="copy-btn" onclick="copyCode(this)">&#x2398;</button> <!-- Copy Icon -->
                    </div>
                `;
            });

            // Preserve white spaces and line breaks (converting space to non-breaking space, line breaks to <br>)
            content = content.replace(/ /g, '&nbsp;')          // Convert space to non-breaking space
                     .replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;') // Convert tabs to 4 non-breaking spaces
                     .replace(/\n/g, '<br>');      // Convert line breaks to <br>

            return content;
        };

        // Function to render related emails
        // const renderRelatedEmails = (relatedEmails) => {
            // if (!relatedEmails || relatedEmails.length === 0) {
            //     return ''; // No related emails, return empty string
            // }

            // return relatedEmails.map(relatedEmail => {
            //     const relatedTimeAgo = relatedEmail.timeAgo || 'Unknown time'; // Format time for related emails

            //     return `
            //         <div class="related-email mt-4">
            //             <div class="email-header">
            //                 <h5 class="font-medium text-lg">${sanitizeHtml(relatedEmail.subject)}</h5>
            //                 <p class="text-sm text-gray-600">From: <strong>${sanitizeHtml(relatedEmail.sender)}</strong> | To: <strong>${sanitizeHtml(relatedEmail.receiver)}</strong></p>
            //                 <p class="text-sm text-gray-500">Sent: <span class="italic">${sanitizeHtml(relatedTimeAgo)}</span></p>
            //             </div>
            //             <div class="email-body mt-2">
            //                 <h6 class="font-medium text-sm">Message:</h6>
            //                 <div class="email-content">${renderMarkdown(relatedEmail.body)}</div>
            //             </div>
            //         </div>
            //     `;
            // }).join(''); // Join the mapped HTML for related emails
        // };

        // Display the main email content
        fullEmailContent.innerHTML = `
            <div class="email-header">
                <h3 class="font-bold text-xl">${sanitizeHtml(email.subject)}</h3>
                <p class="text-sm text-gray-600">From: <strong>${sanitizeHtml(email.sender)}</strong> | To: <strong>${sanitizeHtml(email.receiver)}</strong></p>
                <p class="text-sm text-gray-500">Sent: <span class="italic">${sanitizeHtml(timeAgo)}</span></p>
            </div>
            <div class="email-body mt-4">
               <div class="email-content w-full wrap overflow-wrap break-words">${renderMarkdown(email.body)}</div>
            </div>
            <!--div class="related-emails">
                <h4 class="font-medium text-lg mt-4">Related Emails:</h4>
                renderRelatedEmails(email.relatedEmails) <!-- Render related emails here -->
            </div-->
        `;

        // Navigate to the full email view
        navigate('full-mail');

        // Mark as read after loading
        markAsRead(emailId);

    } catch (error) {
        console.log(error);
        fullEmailContent.innerHTML = '<p class="text-red-500">Error loading email. Please try again later.</p>';
        // Navigate to the full email view
        navigate('full-mail');
    }
}


// Helper function to sanitize inputs, preventing injection attacks
function sanitizeHtml(str) {
    const element = document.createElement('div');
    if (str) {
        element.innerText = str;
        element.textContent = str;
    }
    return element.innerHTML;
}


// Function to show the notification with animated progress bar
function showNotification(message, durationInSeconds) {
    // Get the elements
    const notification = document.getElementById('notification');
    const progressBar = document.getElementById('progress-bar');
    const messageElement = document.getElementById('notification-message');

    // Set the message dynamically
    messageElement.innerText = message;

    // Show the notification
    notification.classList.remove('hidden');
    
    // Reset progress bar
    progressBar.style.width = '0%';

    // Calculate the total time and step for progress bar
    let totalTime = durationInSeconds * 1000; // Convert to milliseconds
    let stepTime = 20; // Update progress bar every 20ms
    let width = 0; // Start from 0% width

    // Animate progress bar
    let interval = setInterval(() => {
        width += (stepTime / totalTime) * 100; // Calculate percentage
        progressBar.style.width = width + '%'; // Update width

        // Once the bar is full, hide notification
        if (width >= 100) {
            clearInterval(interval); // Stop the interval
            setTimeout(() => {
                notification.classList.add('hidden'); // Hide the notification after it finishes
            }, 500); // Wait 0.5s before hiding
        }
    }, stepTime);
}


// Function to copy the code to clipboard
function copyCode(button) {
    const codeBlock = button.previousElementSibling;
    const code = codeBlock.textContent || codeBlock.innerText;

    // Create a temporary input element to copy the code
    const tempInput = document.createElement('input');
    document.body.appendChild(tempInput);
    tempInput.value = code;
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Optionally show a "Copied!" message for a short duration
    const originalText = button.textContent;
    button.textContent = '✔ Copied!';
    setTimeout(() => {
        button.textContent = originalText; // Reset text
    }, 1500);
}

// Function to detect the programming language based on syntax patterns
// Function to detect the programming language based on syntax patterns
function detectLanguage(code) {
    // Check for JavaScript (Common syntax: `function`, `let`, `const`, `class`)
    if (/\b(function|let|const|class|var)\b/.test(code)) {
        return 'js';
    }

    // Check for PHP (Common syntax: `$` for variables, `echo`, `function`)
    // Avoid matching any PHP tags like 
    if (/\b(\$[a-zA-Z_]\w*|function|echo|->)\b/.test(code)) {
        return 'php';
    }

    // Check for Python (Common syntax: `def`, `import`, `class`)
    if (/\b(def|import|class)\b/.test(code)) {
        return 'python';
    }

    // Check for C++ (Common syntax: `#include`, `int main`, `cout`)
    if (/^\s*#include/.test(code) || /\b(int|cout|std::)\b/.test(code)) {
        return 'cpp';
    }

    // Check for Java (Common syntax: `public static void main`, `class`)
    if (/public\s+static\s+void\s+main/.test(code) || /\bclass\b/.test(code)) {
        return 'java';
    }

    // If no patterns matched, return "generic" for unclassified code
    return 'generic';
}
// Function to copy the code to clipboard
function copyCode(button) {
    const codeBlock = button.previousElementSibling;
    const code = codeBlock.textContent || codeBlock.innerText;

    // Create a temporary input element to copy the code
    const tempInput = document.createElement('input');
    document.body.appendChild(tempInput);
    tempInput.value = code;
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Optionally show a "Copied!" message for a short duration
    const originalText = button.textContent;
    button.textContent = '✔ Copied!';
    setTimeout(() => {
        button.textContent = originalText; // Reset text
    }, 1500);
}


        


        async function markAsRead(emailId) {
            try {
                const response = await fetch(`routes/get_email.php?get=read&id=${emailId}`);
                const result = await response.json();

                if (result.success) {
                    loadMailbox();
                } else {
                    alert('Failed to mark as read');
                }
            } catch (error) {
                alert('Error marking email as read');
            }
        }

        function navigateBack() {
            navigate('inbox');
        }

        document.getElementById('compose-form').addEventListener('submit', async e => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
             data.sender = senderemail; //changge developer after costomization this code

            try {
                const response = await fetch('routes/send.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                console.log(result)

                if (result.status) {
                    showNotification("Ghalib Mail Sended Successfully",5);
                    form.reset();
                    loadMailbox();
                    navigate('inbox');
                } else {
                    alert(result.error || 'Failed to send email');
                }
            } catch (error) {
                alert('Error sending email');
            }
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('#sidebarformobile');
            const firstpage = document.querySelector('#sidebarformobile');
            const content = document.querySelector('.main-content');
            sidebar.classList.toggle('hidden');
            content.classList.toggle('hidden');
            sidebar.classList.toggle('anim');
            content.classList.toggle('anim');
        }

        loadMailbox();
    </script>
</body>
</html>
