<?php

/* @gantry-admin/layouts/css-warnings.html.twig */
class __TwigTemplate_131ee334c0d4de05a0946b507e95282d4753cc639b1b7c77b086721c4f55fd97 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'gantry' => array($this, 'block_gantry'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('gantry', $context, $blocks);
    }

    public function block_gantry($context, array $blocks = array())
    {
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["warnings"] ?? null));
        foreach ($context['_seq'] as $context["outline"] => $context["files"]) {
            // line 3
            echo "    <h3>Outline: ";
            echo twig_escape_filter($this->env, $context["outline"], "html", null, true);
            echo "</h3>
    ";
            // line 4
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["files"]);
            foreach ($context['_seq'] as $context["file"] => $context["list"]) {
                // line 5
                echo "        <h4>File: ";
                echo twig_escape_filter($this->env, $context["file"], "html", null, true);
                echo "</h4>
        ";
                // line 6
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["list"]);
                foreach ($context['_seq'] as $context["_key"] => $context["warning"]) {
                    // line 7
                    echo "            <div>";
                    echo twig_escape_filter($this->env, $context["warning"], "html", null, true);
                    echo "</div>
        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['warning'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 9
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['file'], $context['list'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['outline'], $context['files'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "@gantry-admin/layouts/css-warnings.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  57 => 9,  48 => 7,  44 => 6,  39 => 5,  35 => 4,  30 => 3,  26 => 2,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@gantry-admin/layouts/css-warnings.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/layouts/css-warnings.html.twig");
    }
}
