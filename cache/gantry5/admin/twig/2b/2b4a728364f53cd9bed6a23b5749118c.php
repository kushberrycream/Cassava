<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @gantry-admin/pages/menu/menuitem.html.twig */
class __TwigTemplate_2cad100d3248f59474bdbcc29c708a6d extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'gantry' => [$this, 'block_gantry'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate((((($context["ajax"] ?? null) - ($context["suffix"] ?? null))) ? ("@gantry-admin/partials/ajax.html.twig") : ("@gantry-admin/partials/base.html.twig")), "@gantry-admin/pages/menu/menuitem.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_gantry($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "<form method=\"post\" action=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => "menu/edit", 1 => ($context["id"] ?? null), 2 => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "path", [], "any", false, false, false, 4), 3 => "validate"], "method", false, false, false, 4), "html", null, true);
        echo "\">
    <div class=\"card settings-block\">
        <h4>
            <span class=\"g-menuitem-path font-small\">
                ";
        // line 8
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "getEscapedTitles", [0 => false], "method", false, false, false, 8), " <i class=\"fa fa-caret-right\"></i> ");
        echo "
            </span>
            <span data-title-editable=\"";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "title", [], "any", false, false, false, 10), "html", null, true);
        echo "\" class=\"title\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "title", [], "any", false, false, false, 10), "html", null, true);
        echo "</span>
            <i class=\"fa fa-pencil fa-pencil-alt font-small\" aria-hidden=\"true\" tabindex=\"0\" aria-label=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_EDIT_TITLE", twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "title", [], "any", false, false, false, 11)), "html", null, true);
        echo "\" data-title-edit=\"\"></i>
            ";
        // line 12
        if ((($__internal_compile_0 = twig_get_attribute($this->env, $this->source, ($context["blueprints"] ?? null), "fields", [], "any", false, false, false, 12)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[".enabled"] ?? null) : null)) {
            // line 13
            echo "            ";
            $this->loadTemplate("forms/fields/enable/enable.html.twig", "@gantry-admin/pages/menu/menuitem.html.twig", 13)->display(twig_array_merge($context, ["default" => true, "name" => "enabled", "field" => (($__internal_compile_1 = twig_get_attribute($this->env, $this->source, ($context["blueprints"] ?? null), "fields", [], "any", false, false, false, 13)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[".enabled"] ?? null) : null), "value" => twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "enabled", [], "any", false, false, false, 13)]));
            // line 14
            echo "            ";
        }
        // line 15
        echo "        </h4>
        <div class=\"inner-params\">
            ";
        // line 17
        $this->loadTemplate("forms/fields.html.twig", "@gantry-admin/pages/menu/menuitem.html.twig", 17)->display(twig_array_merge($context, ["skip" => [0 => "enabled", 1 => "title", 2 => (((twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "level", [], "any", false, false, false, 17) > 1)) ? ("dropdown") : ("-noitem-"))]]));
        // line 18
        echo "        </div>
    </div>
    <div class=\"g-modal-actions\">
        ";
        // line 21
        if (twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "authorize", [0 => "menu.edit", 1 => ($context["id"] ?? null), 2 => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "path", [], "any", false, false, false, 21)], "method", false, false, false, 21)) {
            // line 22
            echo "        ";
            // line 23
            echo "        <button class=\"button button-primary\" type=\"submit\">";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_APPLY"), "html", null, true);
            echo "</button>
        <button class=\"button button-primary\" data-apply-and-save=\"\">";
            // line 24
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_APPLY_SAVE"), "html", null, true);
            echo "</button>
        ";
        }
        // line 26
        echo "        <button class=\"button g5-dialog-close\">";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CANCEL"), "html", null, true);
        echo "</button>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/pages/menu/menuitem.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 26,  100 => 24,  95 => 23,  93 => 22,  91 => 21,  86 => 18,  84 => 17,  80 => 15,  77 => 14,  74 => 13,  72 => 12,  68 => 11,  62 => 10,  57 => 8,  49 => 4,  45 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/pages/menu/menuitem.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\pages\\menu\\menuitem.html.twig");
    }
}
