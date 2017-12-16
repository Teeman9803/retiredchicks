<?php

/* @gantry-admin/ajax/confirm-deletion.html.twig */
class __TwigTemplate_97f528b63958819cd3ce33e8d9ea47cc701b687289ef67868f4fe8d9ac6fe5c2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'message' => array($this, 'block_message'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"card settings-block\">
    <h4 id=\"g-modal-labelledby\">";
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter(("GANTRY5_PLATFORM_DELETE_" . ($context["page_type"] ?? null))), "html", null, true);
        echo "</h4>
    <div class=\"inner-params\" id=\"g-modal-describedby\">
        ";
        // line 4
        $this->displayBlock('message', $context, $blocks);
        // line 7
        echo "    </div>
</div>

<div class=\"g-modal-actions\">
    <button tabindex=\"0\" class=\"button button-primary\" role=\"button\" aria-label=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_CONFIRM"), "html", null, true);
        echo "\" data-g-delete-confirm=\"\">
        ";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_CONFIRM"), "html", null, true);
        echo "
    </button>
    <button tabindex=\"0\" class=\"button g5-dialog-close\" role=\"button\" aria-label=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_CANCEL"), "html", null, true);
        echo "\" data-g-delete-cancel=\"\">
        ";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_CANCEL"), "html", null, true);
        echo "
    </button>
</div>
";
    }

    // line 4
    public function block_message($context, array $blocks = array())
    {
        // line 5
        echo "        ";
        echo $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter((("GANTRY5_PLATFORM_DELETE_" . ($context["page_type"] ?? null)) . "_DESC"), ($context["outline"] ?? null));
        echo "
        ";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/ajax/confirm-deletion.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 5,  57 => 4,  49 => 15,  45 => 14,  40 => 12,  36 => 11,  30 => 7,  28 => 4,  23 => 2,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@gantry-admin/ajax/confirm-deletion.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/ajax/confirm-deletion.html.twig");
    }
}
