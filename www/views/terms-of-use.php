<?php
$pageTitle = 'Explore DSI';
require __DIR__ . '/header.php';

$totalProjects = (new \DSI\Repository\ProjectRepoInAPC())->countAll();
$totalOrganisations = (new \DSI\Repository\OrganisationRepoInAPC())->countAll();
?>

    <div class="w-section page-header">
        <div class="w-clearfix container-wide header">
            <h1 class="page-h1 light">Terms of use</h1>
        </div>
    </div>

    <div class="w-section section-grey">
        <div class="container-wide">
            <div class="w-row">
                <div class="w-col w-col-12 intro-col">
                    <p>
                        This website is managed by the Latin American Initiative for Open Data, if you do not agree with these Terms or our Privacy Policy, please do not use this site.
                    </p>
                    <p>
                        1. The information, materials and logos on this site belong to our partners or licensors. Unless otherwise indicated, the materials and reports are licensed for use under a Creative Commons Attribution Noncommercial Attribution License (CC-BY-NC-SA), all details at https://creativecommons.org/ licenses / by- nc-sa / 4.0 /. We do not make any representation or guarantee on the content, even in relation to the non-infringement of intellectual property rights.
                    </p>
                    <p>
                        2. You must not use this site: publish, share or transmit material that is illegal or infringes the rights of another person for any commercial purpose or in any way that is abusive, defamatory or obscene or that harasses or distresses any person or restricts or inhibit your use and enjoyment of the site or damage to our reputation by the transmission of viruses or software codes designed to interrupt, destroy or compromise the integrity of software, hardware or telecommunications equipment.
                    </p>
                    <p>
                        3. You are responsible for any comments, text, video, audio, image or other content that you post on the site and you must obtain the relevant permissions or consents to publish this content. You grant us a perpetual, worldwide, non-exclusive, royalty-free and fully transferable right to copy, download, distribute, transmit and adapt your content and renounce your moral rights therein.
                    </p>
                    <p>
                        4. We are not responsible for the content posted on the site by users and third parties. The opinions expressed are not necessarily ours or our associated entities. You may report any inappropriate content to us at contacto@idatosabiertos.org Although we do not monitor all content posted on the site, we reserve the right to do so and to edit or delete the content at our absolute discretion and without prior notice.
                    </p>
                    <p>
                        5. The information on this site is subject to occasional changes and we can not guarantee that it is always accurate and up-to-date. We are not responsible for the content of external sites linked to from this site.
                    </p>
                    <p>
                        6. We do not guarantee that the site will always be available or free of errors or viruses. You are responsible for installing the virus checking software to protect your hardware. To the extent legally possible, we and our partners exclude all liability for any loss or damage suffered as a result of the use or access to our site, whether direct or indirect, and as it arises, including any loss of data or damages By downloading content from our site.
                    </p>
                    <p>
                        7. These Terms may vary from time to time. If you use the site after making any changes, you will be considered to have accepted the change. Additional terms may apply to certain areas of this site, such as requests for grant funds or payment of events.
                    </p>
                    <p>
                        8. These Terms are governed by the law of the Oriental Republic of Uruguay, and any dispute will be resolved according to the same
                    </p>
                    <p>
                        9. This site complies with the provisions of law 18331. The data collected by this site is not considered personal.
                    </p>
                    <p>
                        ILDA is an international civil association registered in the Oriental Republic of Uruguay with the number 396-18 before the Ministry of Foreign Affairs, in the special register for associations of this type.
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/footer.php' ?>