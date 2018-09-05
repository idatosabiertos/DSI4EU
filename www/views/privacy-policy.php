<?php
$pageTitle = 'Explore DSI';
require __DIR__ . '/header.php';

$totalProjects = (new \DSI\Repository\ProjectRepoInAPC())->countAll();
$totalOrganisations = (new \DSI\Repository\OrganisationRepoInAPC())->countAll();
?>

    <div class="w-section page-header">
        <div class="w-clearfix container-wide header">
            <h1 class="page-h1 light">Privacy Policy</h1>
        </div>
    </div>

    <div class="w-section section-grey">
        <div class="container-wide">
            <div class="w-row">
                <div class="w-col w-col-12 intro-col">
                    <p>
                        This website is managed by the Latin American Open Data Initiative
                    </p>

                    <h2 class="home-h2">1. What kind of information do we collect?</h2>
                    <p>
                        When you register or sign up on the site, we will ask for personal information such as your name, email address, location and other personal information. If you register organizations and / or projects, we link them to your personal profile and we will show your name as a collaborator in that organization / project profile. We can also ask for your opinion about digitalsocial.eu or complete surveys. We can register your activity and preferences when you visit the sites (see "Cookies" below). If you post content or communicate through the site, we may also store and control your content and communications.
                    </p>

                    <h2 class="home-h2">2. What do we do with information we collect?</h2>
                    <p>
                        We will use your personal information to operate the site, to send you newsletters, publications and other information about this site, We can also use your information to carry out analysis and research to improve our publications, events and activities, to prevent and detect fraud and abuse , and to protect other users. Make sure that all personal information you provide is accurate and up-to-date, and tell us about any changes. Get the consent first before giving us the information of another person.
                    </p>

                    <h2 class="home-h2">3. How to unsubscribe</h2>
                    <p>
                        If you no longer wish to receive our communications, click on the unsubscribe link in any of our emails or, if available, modify the preferences in your account. If you wish to delete your personal information, send an email to contacto@idatosabiertos.org
                    </p>

                    <h2 class="home-h2">4. Who else has access to your information?</h2>
                    <p>
                        We may share your information with our partners and with companies that help us operate this site and organize events and other activities. Some of these organizations may process your information in countries outside the Eastern Republic of Uruguay, such as the United States, where data protection laws are not the same as in Uruguay (aligned with European Union regulation). You want us to transfer your information in this way, do not access or use our websites.
                    </p>

                    <p>
                        The comments, blogs and other information you post on the site will be publicly displayed and to other users. Be careful when disclosing personal information that may identify you or any other person. We are not responsible for the protection or security of information published in public areas.

                    </p>

                    <p>
                        We may disclose your personal information if required by law, or to protect or defend ourselves or others from illegal or harmful activities, or as part of a reorganization or restructuring.

                    </p>

                    <h2 class="home-h2">5. Cookies</h2>
                    <p>
                        This site contains cookies. Cookies are small text files that are placed on your computer by
                        websites you visit. They are widely used to make websites work, or work more efficiently, as
                        well as
                        to provide information to site owners. Most web browsers allow some control of most cookies
                        through
                        browser settings. To find out more about cookies, including how to see what cookies have been
                        set
                        and how to manage and delete them, visit www.aboutcookies.org or www.allaboutcookies.org.
                    </p>

                    <p>
                        This site uses cookies that are strictly necessary to enable you to move around the site or to
                        provide certain basic features, such as logging into secure areas.
                        The site also uses performance cookies which collect information about how you use the site,
                        such as
                        how you are referred to it and how long you stay on certain pages. This information is
                        aggregated
                        and therefore anonymous and is only used to improve the performance of the site. Some of these
                        performance cookies are Google Analytics web cookies. To opt out of being tracked by Google
                        Analytics across all websites visit http://tools.google.com/dlpage/gaoptout.
                    </p>

                    <h2 class="home-h2">6. Security</h2>
                    <p>
                        We take steps to protect your personal information and follow procedures designed to minimise
                        unauthorised access or disclosure of your information. However, we can’t guarantee to eliminate
                        all
                        risk of misuse. If you have a password for an account on this site, please keep this safe and
                        don’t
                        share it with anyone else. You are responsible for all activity on your account and must contact
                        us
                        immediately if you are aware of any unauthorised use of your password or other security breach.
                    </p>

                    <h2 class="home-h2">7. Contacting us</h2>
                    <p>
                        You have the legal right to know what personal information we have about you and how that information is processed. If you want to know what information we keep about you, you can contact us at contacto@idatosabiertos.org
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/footer.php' ?>