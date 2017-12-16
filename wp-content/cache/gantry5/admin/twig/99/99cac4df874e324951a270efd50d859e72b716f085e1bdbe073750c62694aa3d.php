<?php

/* @gantry-admin/pages/configurations/layouts/particle-preview.html.twig */
class __TwigTemplate_30022a7f7bce7c65fd6ff022977dea36acc6b40a391fdf8bd4bf44cc8577f0dd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'gantry' => array($this, 'block_gantry'),
            'title' => array($this, 'block_title'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate((((($context["ajax"] ?? null) - ($context["suffix"] ?? null))) ? ("@gantry-admin/partials/ajax.html.twig") : ("@gantry-admin/partials/base.html.twig")), "@gantry-admin/pages/configurations/layouts/particle-preview.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_gantry($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"g-tabs\" role=\"tablist\">
    <ul>
        ";
        // line 7
        echo "        <li class=\"active\">
            <a href=\"#\" id=\"g-settings-particle-tab\" role=\"presentation\" aria-controls=\"g-settings-particle\" role=\"tab\" aria-expanded=\"true\">
                ";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        // line 12
        echo "            </a>
        </li>
        ";
        // line 15
        echo "        ";
        if (($context["extra"] ?? null)) {
            // line 16
            echo "        <li>
            <a href=\"#\" id=\"g-settings-block-tab\" role=\"presentation\" aria-controls=\"g-settings-block\" role=\"tab\" aria-expanded=\"false\">
                ";
            // line 18
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_BLOCK"), "html", null, true);
            echo "
            </a>
        </li>
        ";
        }
        // line 22
        echo "    </ul>
</div>

<div class=\"g-panes\">
    ";
        // line 27
        echo "    <div class=\"g-pane active\" role=\"tabpanel\" id=\"g-settings-particle\" aria-labelledby=\"g-settings-particle-tab\" aria-expanded=\"true\">
        <div class=\"g-particle-preview alert alert-warning\"><i class=\"fa fa-fw fa-eye\" aria-hidden=\"true\"></i> ";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_PARTICLE_PREVIEW"), "html", null, true);
        echo "</div>

        ";
        // line 30
        $this->loadTemplate("@gantry-admin/pages/configurations/layouts/particle-card.html.twig", "@gantry-admin/pages/configurations/layouts/particle-preview.html.twig", 30)->display(array_merge($context, array("title" => $this->getAttribute(        // line 31
($context["item"] ?? null), "title", array()), "blueprints" => $this->getAttribute(        // line 32
($context["particle"] ?? null), "form", array()), "overrideable" => (        // line 33
($context["overrideable"] ?? null) && ( !$this->getAttribute($this->getAttribute(($context["particle"] ?? null), "form", array(), "any", false, true), "overrideable", array(), "any", true, true) || $this->getAttribute($this->getAttribute(($context["particle"] ?? null), "form", array()), "overrideable", array()))), "inherit" => (((twig_in_filter("attributes", $this->getAttribute($this->getAttribute(        // line 34
($context["item"] ?? null), "inherit", array()), "include", array())) && twig_in_filter($this->getAttribute($this->getAttribute(($context["item"] ?? null), "inherit", array()), "outline", array()), $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["inheritance"] ?? null), "form", array()), "fields", array()), "outline", array()), "filter", array())))) ? ($this->getAttribute($this->getAttribute(($context["item"] ?? null), "inherit", array()), "outline", array())) : (null)))));
        // line 36
        echo "    </div>

    ";
        // line 39
        echo "    ";
        if (($context["extra"] ?? null)) {
            // line 40
            echo "    <div class=\"g-pane\" role=\"tabpanel\" id=\"g-settings-block\" aria-labelledby=\"g-settings-block-tab\" aria-expanded=\"false\">
        <div class=\"g-particle-preview alert alert-info\"><i class=\"fa fa-fw fa-eye\" aria-hidden=\"true\"></i> ";
            // line 41
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_PARTICLE_PREVIEW"), "html", null, true);
            echo "</div>

        ";
            // line 43
            $this->loadTemplate("@gantry-admin/pages/configurations/layouts/particle-card.html.twig", "@gantry-admin/pages/configurations/layouts/particle-preview.html.twig", 43)->display(array("gantry" =>             // line 44
($context["gantry"] ?? null), "title" => $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_BLOCK"), "blueprints" => $this->getAttribute(            // line 46
($context["extra"] ?? null), "form", array()), "data" => array("block" => $this->getAttribute(            // line 47
($context["item"] ?? null), "block", array())), "prefix" => "block.", "inherit" => (((twig_in_filter("block", $this->getAttribute($this->getAttribute(            // line 49
($context["item"] ?? null), "inherit", array()), "include", array())) && twig_in_filter($this->getAttribute($this->getAttribute(($context["item"] ?? null), "inherit", array()), "outline", array()), $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["inheritance"] ?? null), "form", array()), "fields", array()), "outline", array()), "filter", array())))) ? ($this->getAttribute($this->getAttribute(($context["item"] ?? null), "inherit", array()), "outline", array())) : (null))));
            // line 51
            echo "    </div>
    ";
        }
        // line 53
        echo "</div>

<div class=\"g-modal-actions\">
    <button class=\"button button-primary g5-dialog-close\">";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_CLOSE"), "html", null, true);
        echo "</button>
</div>
";
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
        // line 10
        echo "                ";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_PARTICLE"), "html", null, true);
        echo "
                ";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/pages/configurations/layouts/particle-preview.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 10,  116 => 9,  109 => 56,  104 => 53,  100 => 51,  98 => 49,  97 => 47,  96 => 46,  95 => 44,  94 => 43,  89 => 41,  86 => 40,  83 => 39,  79 => 36,  77 => 34,  76 => 33,  75 => 32,  74 => 31,  73 => 30,  68 => 28,  65 => 27,  59 => 22,  52 => 18,  48 => 16,  45 => 15,  41 => 12,  39 => 9,  35 => 7,  31 => 4,  28 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@gantry-admin/pages/configurations/layouts/particle-preview.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/pages/configurations/layouts/particle-preview.html.twig");
    }
}
