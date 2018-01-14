<?php

/* forms/fields/unknown/unknown.html.twig */
class __TwigTemplate_dcf40feb3e3e2867e9b87b8629d0ca54f6cdf862651a4a1a6e77dc19c9cc848b extends Twig_Template
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
        if ($this->getAttribute(($context["field"] ?? null), "fields", array())) {
            // line 2
            echo "    ";
            $this->loadTemplate("forms/fields/array/list.list.twig", "forms/fields/unknown/unknown.html.twig", 2)->display($context);
        } else {
            // line 4
            echo "    ";
            $this->loadTemplate("forms/fields/input/text.html.twig", "forms/fields/unknown/unknown.html.twig", 4)->display($context);
        }
    }

    public function getTemplateName()
    {
        return "forms/fields/unknown/unknown.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 4,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "forms/fields/unknown/unknown.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/forms/fields/unknown/unknown.html.twig");
    }
}
