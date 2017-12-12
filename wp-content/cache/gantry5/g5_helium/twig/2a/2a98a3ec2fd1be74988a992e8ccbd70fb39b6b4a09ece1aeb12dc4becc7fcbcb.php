<?php

/* index.html.twig */
class __TwigTemplate_ee61f8bcdc2e749a3e2939dceff21b961bea6f3bfc49c1a789ad78fb0a8b8bf4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/page.html.twig", "index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "partials/page.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["twigTemplate"] = "index.html.twig";
        // line 3
        $context["scope"] = "blog";
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <div class=\"platform-content\">
        <div class=\"blog\">

            ";
        // line 11
        echo "            ";
        if (($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "config", array()), "get", array(0 => (("content." . ($context["scope"] ?? null)) . ".heading.enabled"), 1 => "0"), "method") &&  !twig_test_empty($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "config", array()), "get", array(0 => (("content." . ($context["scope"] ?? null)) . ".heading.text")), "method")))) {
            // line 12
            echo "                <header class=\"page-header\">
                    <h1>
                        ";
            // line 14
            echo $this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "config", array()), "get", array(0 => (("content." . ($context["scope"] ?? null)) . ".heading.text")), "method");
            echo "
                    </h1>
                </header>
            ";
        }
        // line 18
        echo "            ";
        // line 19
        echo "
            ";
        // line 21
        echo "            <section class=\"entries\">
                <div class=\"g-grid\">
                    ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["posts"] ?? null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 24
            echo "                        <div class=\"g-block ";
            if ((($this->getAttribute(($context["pagination"] ?? null), "current", array()) == 1) && twig_in_filter("sticky", $this->getAttribute($context["post"], "class", array())))) {
                echo "size-100";
            } else {
                echo (($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "config", array(), "any", false, true), "get", array(0 => (("content." . ($context["scope"] ?? null)) . ".content.columns")), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "config", array(), "any", false, true), "get", array(0 => (("content." . ($context["scope"] ?? null)) . ".content.columns")), "method"), "size-100")) : ("size-100"));
            }
            echo "\">
                            ";
            // line 25
            $this->loadTemplate(array(0 => (("partials/content-" . ($context["scope"] ?? null)) . ".html.twig"), 1 => (($this->getAttribute($context["post"], "format", array())) ? ((("partials/content-" . $this->getAttribute($context["post"], "format", array())) . ".html.twig")) : ("")), 2 => "partials/content.html.twig"), "index.html.twig", 25)->display($context);
            // line 26
            echo "                        </div>
                    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "                </div>
            </section>
            ";
        // line 31
        echo "
            ";
        // line 33
        echo "            ";
        if (($this->getAttribute(($context["pagination"] ?? null), "pages", array()) && (twig_length_filter($this->env, $this->getAttribute(($context["pagination"] ?? null), "pages", array())) > 1))) {
            // line 34
            echo "                ";
            $this->loadTemplate("partials/pagination.html.twig", "index.html.twig", 34)->display($context);
            // line 35
            echo "            ";
        }
        // line 36
        echo "            ";
        // line 37
        echo "
        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 37,  124 => 36,  121 => 35,  118 => 34,  115 => 33,  112 => 31,  108 => 28,  93 => 26,  91 => 25,  82 => 24,  65 => 23,  61 => 21,  58 => 19,  56 => 18,  49 => 14,  45 => 12,  42 => 11,  36 => 6,  33 => 5,  29 => 1,  27 => 3,  25 => 2,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/themes/g5_helium/views/index.html.twig");
    }
}
