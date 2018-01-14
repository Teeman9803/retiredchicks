<?php

/* forms/fields/wordpress/posts.html.twig */
class __TwigTemplate_7e093e8bb69196a3a35fd681b749148c4c8f6aa38bc66ca66d9979c989342458 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("forms/fields/input/selectize.html.twig", "forms/fields/wordpress/posts.html.twig", 1);
        $this->blocks = array(
            'global_attributes' => array($this, 'block_global_attributes'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "forms/fields/input/selectize.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_global_attributes($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $context["post_type"] = (($this->getAttribute(($context["field"] ?? null), "post_type", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "post_type", array()), "page")) : ("page"));
        // line 5
        echo "    ";
        $context["post_status"] = (($this->getAttribute(($context["field"] ?? null), "post_status", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "post_status", array()), "publish")) : ("publish"));
        // line 6
        echo "    ";
        $context["posts_per_page"] = (($this->getAttribute(($context["field"] ?? null), "posts_per_page", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "posts_per_page", array()), "-1")) : ("-1"));
        // line 7
        echo "    ";
        $context["orderby"] = (($this->getAttribute(($context["field"] ?? null), "orderby", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "orderby", array()), "title")) : ("title"));
        // line 8
        echo "    ";
        $context["order"] = (($this->getAttribute(($context["field"] ?? null), "order", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "order", array()), "asc")) : ("asc"));
        // line 9
        echo "    ";
        $context["array"] = array("post_type" =>         // line 10
($context["post_type"] ?? null), "post_status" =>         // line 11
($context["post_status"] ?? null), "posts_per_page" =>         // line 12
($context["posts_per_page"] ?? null), "orderby" =>         // line 13
($context["orderby"] ?? null), "order" =>         // line 14
($context["order"] ?? null));
        // line 16
        echo "    ";
        $context["posts"] = $this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "platform", array()), "call", array(0 => "Timber::get_posts", 1 => ($context["array"] ?? null)), "method");
        // line 17
        echo "    ";
        $context["Options"] = $this->getAttribute($this->getAttribute(($context["field"] ?? null), "selectize", array()), "Options", array());
        // line 18
        echo "    ";
        $context["options"] = array();
        // line 19
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["posts"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["post"]) {
            // line 20
            echo "            ";
            $context["id"] = $this->getAttribute($context["post"], "id", array());
            // line 21
            echo "            ";
            $context["options"] = twig_array_merge(($context["options"] ?? null), array(0 => array("value" => $context["id"], "text" => $this->getAttribute($context["post"], "post_title", array()))));
            // line 22
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "
        ";
        // line 24
        $context["field"] = twig_array_merge(twig_array_merge(($context["field"] ?? null), (($this->getAttribute($this->getAttribute(($context["field"] ?? null), "selectize", array(), "any", false, true), "Options", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["field"] ?? null), "selectize", array(), "any", false, true), "Options", array()), array())) : (array()))), array("selectize" => array("Options" => ($context["options"] ?? null), "create" => false)));
        // line 25
        echo "    ";
        $this->displayParentBlock("global_attributes", $context, $blocks);
        echo "
";
    }

    public function getTemplateName()
    {
        return "forms/fields/wordpress/posts.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 25,  83 => 24,  80 => 23,  74 => 22,  71 => 21,  68 => 20,  63 => 19,  60 => 18,  57 => 17,  54 => 16,  52 => 14,  51 => 13,  50 => 12,  49 => 11,  48 => 10,  46 => 9,  43 => 8,  40 => 7,  37 => 6,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "forms/fields/wordpress/posts.html.twig", "/Applications/MAMP/htdocs/retiredchicks/wp-content/plugins/gantry5/admin/templates/forms/fields/wordpress/posts.html.twig");
    }
}
