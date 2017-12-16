<?php

/* @gantry-admin/partials/php_unsupported.html.twig */
class __TwigTemplate_66a3734033dca0f37f824c44ae73c0e607d792bba12788c9260adfebb90ff41a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["php_version"] = twig_constant("PHP_VERSION");
        // line 2
        echo "
";
        // line 3
        if ((is_string($__internal_e2953e015ee27133a1786ae100e99495d26710c2b3c9615d6d6daf45e5ffd491 = ($context["php_version"] ?? null)) && is_string($__internal_b6c89608561c303b5e120e90469419a4e02fa73a2698271661a66ccda69bafb4 = "5.4") && ('' === $__internal_b6c89608561c303b5e120e90469419a4e02fa73a2698271661a66ccda69bafb4 || 0 === strpos($__internal_e2953e015ee27133a1786ae100e99495d26710c2b3c9615d6d6daf45e5ffd491, $__internal_b6c89608561c303b5e120e90469419a4e02fa73a2698271661a66ccda69bafb4)))) {
            // line 4
            echo "<div class=\"g-grid\">
    <div class=\"g-block alert alert-warning g-php-outdated\">
        ";
            // line 6
            echo $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_PHP54_WARNING", ($context["php_version"] ?? null));
            echo "
    </div>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "@gantry-admin/partials/php_unsupported.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 6,  26 => 4,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@gantry-admin/partials/php_unsupported.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/partials/php_unsupported.html.twig");
    }
}
