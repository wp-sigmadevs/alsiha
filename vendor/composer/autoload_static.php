<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc003d3465da73971f9a25757cadedbfa
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SigmaDevs\\Sigma\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SigmaDevs\\Sigma\\' => 
        array (
            0 => __DIR__ . '/../..' . '/framework',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SigmaDevs\\Sigma\\App\\Backend\\Enqueue' => __DIR__ . '/../..' . '/framework/App/Backend/Enqueue.php',
        'SigmaDevs\\Sigma\\App\\Backend\\RequiredPlugins' => __DIR__ . '/../..' . '/framework/App/Backend/RequiredPlugins.php',
        'SigmaDevs\\Sigma\\App\\Frontend\\CSSVariables' => __DIR__ . '/../..' . '/framework/App/Frontend/CSSVariables.php',
        'SigmaDevs\\Sigma\\App\\Frontend\\Enqueue' => __DIR__ . '/../..' . '/framework/App/Frontend/Enqueue.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer' => __DIR__ . '/../..' . '/framework/App/General/Customizer.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Blog' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Blog.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Colors' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Colors.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Container' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Container.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Footer' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Footer.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\General' => __DIR__ . '/../..' . '/framework/App/General/Customizer/General.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Header' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Header.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Page' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Page.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\ThemeOptions' => __DIR__ . '/../..' . '/framework/App/General/Customizer/ThemeOptions.php',
        'SigmaDevs\\Sigma\\App\\General\\Customizer\\Typography' => __DIR__ . '/../..' . '/framework/App/General/Customizer/Typography.php',
        'SigmaDevs\\Sigma\\App\\General\\Hooks' => __DIR__ . '/../..' . '/framework/App/General/Hooks.php',
        'SigmaDevs\\Sigma\\App\\General\\PageTemplates' => __DIR__ . '/../..' . '/framework/App/General/PageTemplates.php',
        'SigmaDevs\\Sigma\\App\\General\\PostTypes' => __DIR__ . '/../..' . '/framework/App/General/PostTypes.php',
        'SigmaDevs\\Sigma\\Bootstrap' => __DIR__ . '/../..' . '/framework/Bootstrap.php',
        'SigmaDevs\\Sigma\\Common\\Abstracts\\Base' => __DIR__ . '/../..' . '/framework/Common/Abstracts/Base.php',
        'SigmaDevs\\Sigma\\Common\\Abstracts\\CustomizerBase' => __DIR__ . '/../..' . '/framework/Common/Abstracts/CustomizerBase.php',
        'SigmaDevs\\Sigma\\Common\\Abstracts\\Enqueue' => __DIR__ . '/../..' . '/framework/Common/Abstracts/Enqueue.php',
        'SigmaDevs\\Sigma\\Common\\Abstracts\\Shortcode' => __DIR__ . '/../..' . '/framework/Common/Abstracts/Shortcode.php',
        'SigmaDevs\\Sigma\\Common\\Abstracts\\Widgets' => __DIR__ . '/../..' . '/framework/Common/Abstracts/Widgets.php',
        'SigmaDevs\\Sigma\\Common\\Functions' => __DIR__ . '/../..' . '/framework/Common/Functions.php',
        'SigmaDevs\\Sigma\\Common\\Models\\Breadcrumbs' => __DIR__ . '/../..' . '/framework/Common/Models/Breadcrumbs.php',
        'SigmaDevs\\Sigma\\Common\\Models\\CustomPostType' => __DIR__ . '/../..' . '/framework/Common/Models/CustomPostType.php',
        'SigmaDevs\\Sigma\\Common\\Models\\CustomTaxonomy' => __DIR__ . '/../..' . '/framework/Common/Models/CustomTaxonomy.php',
        'SigmaDevs\\Sigma\\Common\\Models\\PageTemplates' => __DIR__ . '/../..' . '/framework/Common/Models/PageTemplates.php',
        'SigmaDevs\\Sigma\\Common\\Models\\Pagination' => __DIR__ . '/../..' . '/framework/Common/Models/Pagination.php',
        'SigmaDevs\\Sigma\\Common\\Models\\Templates' => __DIR__ . '/../..' . '/framework/Common/Models/Templates.php',
        'SigmaDevs\\Sigma\\Common\\Traits\\Requester' => __DIR__ . '/../..' . '/framework/Common/Traits/Requester.php',
        'SigmaDevs\\Sigma\\Common\\Traits\\Singleton' => __DIR__ . '/../..' . '/framework/Common/Traits/Singleton.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Actions' => __DIR__ . '/../..' . '/framework/Common/Utils/Actions.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Callbacks' => __DIR__ . '/../..' . '/framework/Common/Utils/Callbacks.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Errors' => __DIR__ . '/../..' . '/framework/Common/Utils/Errors.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Filters' => __DIR__ . '/../..' . '/framework/Common/Utils/Filters.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Helpers' => __DIR__ . '/../..' . '/framework/Common/Utils/Helpers.php',
        'SigmaDevs\\Sigma\\Common\\Utils\\Notice' => __DIR__ . '/../..' . '/framework/Common/Utils/Notice.php',
        'SigmaDevs\\Sigma\\Compatibility\\ACF' => __DIR__ . '/../..' . '/framework/Compatibility/ACF.php',
        'SigmaDevs\\Sigma\\Compatibility\\Jetpack' => __DIR__ . '/../..' . '/framework/Compatibility/Jetpack.php',
        'SigmaDevs\\Sigma\\Compatibility\\WooCommerce' => __DIR__ . '/../..' . '/framework/Compatibility/WooCommerce.php',
        'SigmaDevs\\Sigma\\Config\\Classes' => __DIR__ . '/../..' . '/framework/Config/Classes.php',
        'SigmaDevs\\Sigma\\Config\\Debloater' => __DIR__ . '/../..' . '/framework/Config/Debloater.php',
        'SigmaDevs\\Sigma\\Config\\I18n' => __DIR__ . '/../..' . '/framework/Config/I18n.php',
        'SigmaDevs\\Sigma\\Config\\Requirements' => __DIR__ . '/../..' . '/framework/Config/Requirements.php',
        'SigmaDevs\\Sigma\\Config\\Setup' => __DIR__ . '/../..' . '/framework/Config/Setup.php',
        'SigmaDevs\\Sigma\\Config\\Sidebar' => __DIR__ . '/../..' . '/framework/Config/Sidebar.php',
        'SigmaDevs\\Sigma\\Config\\Theme' => __DIR__ . '/../..' . '/framework/Config/Theme.php',
        'SigmaDevs\\Sigma\\Integrations\\Shortcodes\\SocialProfiles' => __DIR__ . '/../..' . '/framework/Integrations/Shortcodes/SocialProfiles.php',
        'SigmaDevs\\Sigma\\Integrations\\Widgets\\SocialProfiles' => __DIR__ . '/../..' . '/framework/Integrations/Widgets/SocialProfiles.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc003d3465da73971f9a25757cadedbfa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc003d3465da73971f9a25757cadedbfa::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc003d3465da73971f9a25757cadedbfa::$classMap;

        }, null, ClassLoader::class);
    }
}
